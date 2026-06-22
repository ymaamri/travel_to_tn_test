<?php

namespace App\Http\Controllers;

use App\Models\TransportInfo;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    /**
     * Show the list of all transport categories from database.
     */
    public function index()
    {
        $transports = TransportInfo::published()->latest()->get();
        return view('transport.index', compact('transports'));
    }

    /**
     * Show a specific transport guide by slug.
     */
    public function show($slug)
    {
        $transport = TransportInfo::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('transport.show', compact('transport'));
    }
}