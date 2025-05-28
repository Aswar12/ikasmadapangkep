<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    /**
     * Show the form for creating a new job vacancy.
     */
    public function create()
    {
        return view('alumni.jobs.create');
    }

    /**
     * Store a newly created job vacancy in storage.
     */
    public function store(Request $request)
    {
        // Validate and store job vacancy logic here
        return redirect()->route('alumni.jobs')->with('success', 'Lowongan kerja berhasil dibuat');
    }
}
