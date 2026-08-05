<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\School;
use Illuminate\Http\Request;

class AdminDeliveryController extends Controller
{
    /**
     * Display a listing of all deliveries for administrative monitoring.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Delivery::with(['order.customer', 'order.canteen.school', 'courier']);

        // Filter by delivery status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by school (via canteen)
        if ($request->has('school_id') && $request->school_id !== 'all') {
            $query->whereHas('order.canteen', function ($q) use ($request) {
                $q->where('school_id', $request->school_id);
            });
        }

        // Search by order ID, courier name, or customer name
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                  ->orWhereHas('order', function ($subQ) use ($search) {
                      $subQ->where('id', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('courier', function ($subQ) use ($search) {
                      $subQ->where('name', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('order.customer', function ($subQ) use ($search) {
                      $subQ->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $deliveries = $query->latest()->paginate(10);
        $schools = School::all(); // For filter dropdown

        // Get all possible statuses for deliveries
        $statuses = ['DELIVERING', 'DELIVERED', 'COMPLETED', 'CANCELLED'];

        return view('admin.deliveries.index', compact('deliveries', 'schools', 'statuses'));
    }
}
