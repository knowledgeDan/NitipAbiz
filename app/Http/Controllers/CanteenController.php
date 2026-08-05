<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CanteenController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $canteens = Canteen::where('school_id', $user->school_id)
                           ->where('status', 'active') // Assuming 'active' status means available
                           ->get();

        return view('customer.canteens.index', compact('canteens'));
    }
}
