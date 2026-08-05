<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    /**
     * Display a basic overview of platform statistics as a report placeholder.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalSchools = School::count();
        $totalCanteens = Canteen::count();
        $totalOrders = Order::count();
        $totalDeliveries = Delivery::count();

        // You can add more complex logic here for actual reports later
        // For MVP, this serves as a dashboard/summary page

        return view('admin.reports.index', compact(
            'totalUsers',
            'totalSchools',
            'totalCanteens',
            'totalOrders',
            'totalDeliveries'
        ));
    }
}
