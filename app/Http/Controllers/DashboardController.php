<?php

namespace App\Http\Controllers;

use App\Models\Order; // Import the Order model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class DashboardController extends Controller
{
    /**
     * Display the user's dashboard based on their role.
     * For customers, it displays ongoing orders.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user(); // Use Auth facade for consistency
        
        switch ($user->role) {
            case 'customer':
                // Fetch ongoing orders for the customer
                $ongoingOrders = Order::where('customer_id', $user->id)
                                      ->whereNotIn('status', ['COMPLETED', 'CANCELLED'])
                                      ->with(['canteen', 'orderItems.menu']) // Eager load necessary relationships
                                      ->latest()
                                      ->get();
                return view('dashboard.customer', compact('ongoingOrders'));
            case 'seller':
                return view('dashboard.seller'); // These will be updated later
            case 'courier':
                return view('dashboard.courier'); // These will be updated later
            case 'system_manager':
                return view('dashboard.system-manager'); // These will be updated later
            default:
                return view('dashboard.customer'); // Default to customer view
        }
    }
}
