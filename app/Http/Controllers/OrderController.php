<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Canteen;
use App\Models\Delivery; // Added for updating delivery status
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Added for database transactions

class OrderController extends Controller
{
    /**
     * Display the order history for the authenticated customer.
     *
     * @return \Illuminate\View\View
     */
    public function history()
    {
        $user = Auth::user();
        $orders = Order::where('customer_id', $user->id)
                       ->whereIn('status', ['COMPLETED', 'CANCELLED']) // Only show completed or cancelled orders
                       ->with(['canteen', 'orderItems.menu']) // Eager load relationships for display
                       ->latest()
                       ->get();

        return view('customer.orders.history', compact('orders'));
    }

    /**
     * Display current orders for the authenticated seller's canteens.
     *
     * @return \Illuminate\View\View
     */
    public function sellerIndex()
    {
        $user = Auth::user();
        // Get all canteen IDs owned by the current seller
        $canteenIds = Canteen::where('owner_id', $user->id)->pluck('id');

        // Fetch orders for these canteens that are not yet completed or cancelled
        $orders = Order::whereIn('canteen_id', $canteenIds)
                       ->whereNotIn('status', ['COMPLETED', 'CANCELLED'])
                       ->with(['customer', 'orderItems.menu']) // Eager load customer and menu details
                       ->latest()
                       ->get();

        return view('seller.orders.index', compact('orders'));
    }

    /**
     * Update the status of a specific order by a seller.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Order $order)
    {
        $user = Auth::user();
        // Get all canteen IDs owned by the current seller to check ownership
        $canteenIds = Canteen::where('owner_id', $user->id)->pluck('id')->toArray();

        // Ensure the order belongs to one of the seller's canteens
        if (!in_array($order->canteen_id, $canteenIds)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengubah pesanan ini.');
        }

        $request->validate([
            'status' => 'required|in:ACCEPTED,PREPARING,READY_FOR_PICKUP,CANCELLED',
        ]);

        $currentStatus = $order->status;
        $newStatus = $request->status;

        // Implement status transition logic based on PRD
        if ($newStatus === 'CANCELLED' && $currentStatus === 'PENDING') {
            $order->status = $newStatus;
        } elseif ($newStatus === 'ACCEPTED' && $currentStatus === 'PENDING') {
            $order->status = $newStatus;
        } elseif ($newStatus === 'PREPARING' && $currentStatus === 'ACCEPTED') {
            $order->status = $newStatus;
        } elseif ($newStatus === 'READY_FOR_PICKUP' && $currentStatus === 'PREPARING') {
            $order->status = $newStatus;
        } else {
            return redirect()->back()->with('error', 'Transisi status tidak valid dari ' . $currentStatus . ' ke ' . $newStatus);
        }

        $order->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Allows a customer to confirm receipt of a delivered order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmReceipt(Order $order)
    {
        $user = Auth::user();

        // Ensure the order belongs to the authenticated customer
        if ($order->customer_id !== $user->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengkonfirmasi pesanan ini.');
        }

        // Only allow confirmation if the order is in 'DELIVERED' status
        if ($order->status !== 'DELIVERED') {
            return redirect()->back()->with('error', 'Pesanan tidak dalam status siap dikonfirmasi.');
        }

        DB::beginTransaction();
        try {
            $order->status = 'COMPLETED';
            $order->save();

            // Update the associated delivery record to COMPLETED as well
            $delivery = Delivery::where('order_id', $order->id)
                                ->where('status', 'DELIVERED')
                                ->first();
            if ($delivery) {
                $delivery->status = 'COMPLETED';
                $delivery->save();
            }

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Pesanan berhasil dikonfirmasi dan diselesaikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengkonfirmasi pesanan: ' . $e->getMessage());
        }
    }
}
