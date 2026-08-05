<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\School;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of all orders for administrative monitoring.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'canteen.school', 'courier', 'orderItems.menu']);

        // Filter by order status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by school
        if ($request->has('school_id') && $request->school_id !== 'all') {
            $query->whereHas('canteen', function ($q) use ($request) {
                $q->where('school_id', $request->school_id);
            });
        }

        // Search by order ID or customer/canteen name (basic example)
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                  ->orWhereHas('customer', function ($subQ) use ($search) {
                      $subQ->where('name', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('canteen', function ($subQ) use ($search) {
                      $subQ->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $orders = $query->latest()->paginate(10);
        $schools = School::all(); // For filter dropdown

        // Get all possible statuses from a definition or hardcode for now
        $statuses = [
            'PENDING', 'ACCEPTED', 'PREPARING', 'READY_FOR_PICKUP', 
            'DELIVERING', 'DELIVERED', 'COMPLETED', 'CANCELLED'
        ];

        return view('admin.orders.index', compact('orders', 'schools', 'statuses'));
    }
}
