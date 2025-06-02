<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments
     */
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'verifier']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by year
        if ($request->has('year') && $request->year !== 'all') {
            $query->where('year', $request->year);
        }

        // Search by user name or payment code
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('payment_code', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get statistics
        $statistics = [
            'total' => Payment::count(),
            'pending' => Payment::pending()->count(),
            'waiting' => Payment::waitingVerification()->count(),
            'verified' => Payment::verified()->count(),
            'rejected' => Payment::rejected()->count(),
            'total_amount' => Payment::verified()->sum('amount')
        ];

        // Get available years for filter
        $years = Payment::selectRaw('DISTINCT year')->orderBy('year', 'desc')->pluck('year');

        return view('admin.payments.index', compact('payments', 'statistics', 'years'));
    }

    /**
     * Display the specified payment
     */
    public function show(Payment $payment)
    {
        $payment->load(['user', 'verifier']);
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Approve payment
     */
    public function approve(Request $request, Payment $payment)
    {
        if (!$payment->canBeVerified()) {
            return redirect()->back()->with('error', 'Pembayaran ini tidak dapat diverifikasi.');
        }

        DB::beginTransaction();
        try {
            $payment->update([
                'status' => 'verified',
                'verified_by' => Auth::id(),
                'verified_at' => now()
            ]);

            // Create notification for user
            $this->createNotification(
                $payment->user_id,
                'Pembayaran Disetujui',
                'Pembayaran iuran tahun ' . $payment->year . ' telah disetujui.'
            );

            DB::commit();

            return redirect()->back()->with('success', 'Pembayaran berhasil disetujui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui pembayaran.');
        }
    }

    /**
     * Reject payment
     */
    public function reject(Request $request, Payment $payment)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        if (!$payment->canBeVerified()) {
            return redirect()->back()->with('error', 'Pembayaran ini tidak dapat ditolak.');
        }

        DB::beginTransaction();
        try {
            $payment->update([
                'status' => 'rejected',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'rejection_reason' => $request->rejection_reason
            ]);

            // Create notification for user
            $this->createNotification(
                $payment->user_id,
                'Pembayaran Ditolak',
                'Pembayaran iuran tahun ' . $payment->year . ' ditolak. Alasan: ' . $request->rejection_reason
            );

            DB::commit();

            return redirect()->back()->with('success', 'Pembayaran berhasil ditolak.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak pembayaran.');
        }
    }

    /**
     * Bulk approve payments
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'payment_ids' => 'required|array',
            'payment_ids.*' => 'exists:payments,id'
        ]);

        $approvedCount = 0;
        $errors = [];

        DB::beginTransaction();
        try {
            foreach ($request->payment_ids as $paymentId) {
                $payment = Payment::find($paymentId);
                
                if ($payment->canBeVerified()) {
                    $payment->update([
                        'status' => 'verified',
                        'verified_by' => Auth::id(),
                        'verified_at' => now()
                    ]);

                    $this->createNotification(
                        $payment->user_id,
                        'Pembayaran Disetujui',
                        'Pembayaran iuran tahun ' . $payment->year . ' telah disetujui.'
                    );

                    $approvedCount++;
                } else {
                    $errors[] = 'Pembayaran ' . $payment->payment_code . ' tidak dapat disetujui.';
                }
            }

            DB::commit();

            $message = $approvedCount . ' pembayaran berhasil disetujui.';
            if (count($errors) > 0) {
                $message .= ' ' . implode(' ', $errors);
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui pembayaran.');
        }
    }

    /**
     * Export payments report
     */
    public function export(Request $request)
    {
        // This is a placeholder for export functionality
        // You can implement CSV/Excel export here
        return redirect()->back()->with('info', 'Fitur export akan segera tersedia.');
    }

    /**
     * Create notification
     */
    private function createNotification($userId, $title, $message)
    {
        try {
            DB::table('notifications')->insert([
                'user_id' => $userId,
                'title' => $title,
                'message' => $message,
                'type' => 'payment',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } catch (\Exception $e) {
            \Log::warning('Failed to create notification: ' . $e->getMessage());
        }
    }
}
