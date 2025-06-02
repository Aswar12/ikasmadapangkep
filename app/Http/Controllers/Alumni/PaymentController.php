<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments
     */
    public function index()
    {
        $payments = Payment::where('user_id', Auth::id())
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get years that need payment (last 5 years)
        $currentYear = date('Y');
        $startYear = 2025; // Alumni payments start from 2025
        $years = range($startYear, $currentYear);
        
        // Check which years already have payments
        $paidYears = Payment::where('user_id', Auth::id())
            ->whereIn('status', ['waiting_verification', 'verified'])
            ->pluck('year')
            ->toArray();

        $unpaidYears = array_diff($years, $paidYears);

        return view('alumni.payments.index', compact('payments', 'unpaidYears'));
    }

    /**
     * Show the form for creating a new payment
     */
    public function create(Request $request)
    {
        $year = $request->input('year', date('Y'));
        
        // Check if payment already exists for this year
        $existingPayment = Payment::where('user_id', Auth::id())
            ->where('year', $year)
            ->first();

        if ($existingPayment && !$existingPayment->isEditable()) {
            return redirect()->route('alumni.payments')
                ->with('error', 'Pembayaran untuk tahun ' . $year . ' sudah ada dan tidak dapat diubah.');
        }

        // Get list of other alumni users for "pay for friend" feature
        $friends = User::where('id', '!=', Auth::id())
            ->where('role', 'alumni')
            ->where('status', 'approved')
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'email', 'angkatan']);

        return view('alumni.payments.create', compact('year', 'existingPayment', 'friends'));
    }

    /**
     * Store a newly created payment
     */
    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'payment_method' => 'required|in:transfer,cash',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes' => 'nullable|string|max:500',
            'pay_for_next_year' => 'nullable|boolean',
            'pay_for_friend' => 'nullable|boolean',
            'friend_user_id' => 'nullable|integer|exists:users,id'
        ]);

        $year = $request->input('year');
        $payForNextYear = $request->boolean('pay_for_next_year');
        $payForFriend = $request->boolean('pay_for_friend');
        $friendUserId = $request->input('friend_user_id');

        // Check if payment already exists
        $existingPayment = Payment::where('user_id', Auth::id())
            ->where('year', $year)
            ->first();

        if ($existingPayment && !$existingPayment->isEditable()) {
            return redirect()->route('alumni.payments')
                ->with('error', 'Pembayaran untuk tahun ' . $year . ' sudah ada dan tidak dapat diubah.');
        }

        DB::beginTransaction();
        try {
            // Handle file upload
            $file = $request->file('payment_proof');
            
            if (!$file || !$file->isValid()) {
                throw new \Exception('File upload tidak valid');
            }
            
            // Ensure the directory exists
            $directory = 'payment-proofs';
            $storagePath = storage_path('app/public/' . $directory);
            
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0777, true);
            }
            
            $filename = 'payment_' . Auth::id() . '_' . $year . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Move file directly to storage path
            $file->move($storagePath, $filename);
            $path = $directory . '/' . $filename;

            // Default payment amount
            $baseAmount = 50000;
            
            // Determine user to pay for
            $userIdToPay = Auth::id();
            if ($payForFriend && $friendUserId) {
                $userIdToPay = $friendUserId;
            }

            $paymentData = [
                'user_id' => $userIdToPay,
                'year' => $year,
                'payment_code' => Payment::generatePaymentCode(),
                'amount' => $baseAmount,
                'payment_method' => $request->input('payment_method'),
                'payment_proof' => $path,
                'status' => 'waiting_verification',
                'paid_at' => now(),
                'notes' => $request->input('notes')
            ];

            // If paying for friend, add a note about who paid
            if ($payForFriend && $friendUserId) {
                $paymentData['notes'] = ($paymentData['notes'] ? $paymentData['notes'] . "\n" : '') . 
                    "Dibayarkan oleh: " . Auth::user()->name . " (" . Auth::user()->email . ")";
            }

            $existingPayment = Payment::where('user_id', $userIdToPay)
                ->where('year', $year)
                ->first();

            if ($existingPayment) {
                // Delete old proof if exists
                if ($existingPayment->payment_proof) {
                    $oldFilePath = storage_path('app/public/' . $existingPayment->payment_proof);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $existingPayment->update($paymentData);
            } else {
                Payment::create($paymentData);
            }

            DB::commit();

            $successMessage = 'Bukti pembayaran berhasil diunggah dan sedang menunggu verifikasi.';
            if ($payForFriend && $friendUserId) {
                $friend = User::find($friendUserId);
                $successMessage .= ' Pembayaran untuk ' . $friend->name . ' telah dicatat.';
            }

            return redirect()->route('alumni.payments')
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            DB::rollback();

            if (isset($path)) {
                $filePath = storage_path('app/public/' . $path);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            \Log::error('Payment store error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengunggah bukti pembayaran.')
                ->withInput();
        }
    }

    /**
     * Display the specified payment
     */
    public function show(Payment $payment)
    {
        // Check ownership
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        return view('alumni.payments.show', compact('payment'));
    }

    /**
     * Download payment proof
     */
    public function downloadProof(Payment $payment)
    {
        // Check ownership
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$payment->payment_proof) {
            return redirect()->back()->with('error', 'Bukti pembayaran tidak ditemukan.');
        }
        
        $filePath = storage_path('app/public/' . $payment->payment_proof);
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File bukti pembayaran tidak ditemukan.');
        }

        return response()->download($filePath);
    }
}
