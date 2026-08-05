<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    /**
     * Display the application settings page (placeholder for MVP).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // For MVP, this can be a simple placeholder page.
        // In a full implementation, this would fetch various configurable settings.
        return view('admin.settings.index');
    }
}
