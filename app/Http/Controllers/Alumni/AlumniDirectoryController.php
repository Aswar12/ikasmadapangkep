<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;

class AlumniDirectoryController extends Controller
{
    /**
     * Display the alumni directory page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('alumni.directory');
    }
}
