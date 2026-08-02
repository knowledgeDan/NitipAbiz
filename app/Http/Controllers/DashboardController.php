<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        switch ($user->role) {
            case 'customer':
                return view('dashboard.customer');
            case 'seller':
                return view('dashboard.seller');
            case 'courier':
                return view('dashboard.courier');
            case 'system_manager':
                return view('dashboard.system-manager');
            default:
                return view('dashboard.customer');
        }
    }
}
