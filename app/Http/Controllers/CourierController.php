<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourierController extends Controller
{
    public function availableOrders()
    {
        $user = Auth::user();
        if ($user->courier_status !== 'VERIFIED' || !$user->courier_available) {
            return redirect()->route('dashboard')->with('error', 'Anda belum diverifikasi sebagai kurir atau tidak tersedia.');
        }

        $availableOrders = Order::where('status', 'READY_FOR_PICKUP')
                                ->where('school_id', $user->school_id) // Courier only sees orders from their school
                                ->whereNull('courier_id') // Not yet accepted by any courier
                                ->with(['canteen', 'customer', 'orderItems.menu'])
                                ->latest()
                                ->get();
                                
        $ongoingDelivery = Delivery::where('courier_id', $user->id)
                                   ->whereIn('status', ['DELIVERING'])
                                   ->with(['order.canteen', 'order.customer', 'order.orderItems.menu'])
                                   ->first();

        return view('courier.available_orders', compact('availableOrders', 'ongoingDelivery'));
    }

    public function acceptOrder(Request $request, Order $order)
    {
        $user = Auth::user();
        if ($user->courier_status !== 'VERIFIED' || !$user->courier_available) {
            return redirect()->back()->with('error', 'Anda belum diverifikasi sebagai kurir atau tidak tersedia.');
        }
        
        // Prevent accepting if already has an ongoing delivery
        $ongoingDelivery = Delivery::where('courier_id', $user->id)
                                   ->whereIn('status', ['DELIVERING'])
                                   ->first();
        if ($ongoingDelivery) {
            return redirect()->back()->with('error', 'Anda sudah memiliki pesanan yang sedang diantar.');
        }

        if ($order->status === 'READY_FOR_PICKUP' && $order->courier_id === null && $order->school_id === $user->school_id) {
            DB::beginTransaction();
            try {
                $order->courier_id = $user->id;
                $order->status = 'DELIVERING'; // Directly to DELIVERING as per PRD
                $order->save();

                Delivery::create([
                    'order_id' => $order->id,
                    'courier_id' => $user->id,
                    'status' => 'DELIVERING',
                    'earnings' => Order::DELIVERY_FEE, // Fixed earnings
                ]);

                DB::commit();
                return redirect()->route('courier.deliveries')->with('success', 'Pesanan berhasil diambil dan sedang diantar.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Gagal mengambil pesanan: ' . $e->getMessage());
            }
        }
        return redirect()->back()->with('error', 'Pesanan tidak tersedia untuk diambil.');
    }

    public function deliveries()
    {
        $user = Auth::user();
        $deliveries = Delivery::where('courier_id', $user->id)
                              ->whereIn('status', ['DELIVERING', 'DELIVERED']) // Couriers might also see their own 'DELIVERED' state pending customer confirmation
                              ->with(['order.canteen', 'order.customer', 'order.orderItems.menu'])
                              ->latest()
                              ->get();

        return view('courier.deliveries', compact('deliveries'));
    }

    public function markAsDelivered(Order $order)
    {
        $user = Auth::user();
        $delivery = Delivery::where('order_id', $order->id)
                            ->where('courier_id', $user->id)
                            ->where('status', 'DELIVERING')
                            ->first();

        if (!$delivery) {
            return redirect()->back()->with('error', 'Pengantaran tidak ditemukan atau Anda tidak berwenang.');
        }

        DB::beginTransaction();
        try {
            $order->status = 'DELIVERED'; // Order status changes to DELIVERED
            $order->save();

            $delivery->status = 'DELIVERED'; // Delivery status also to DELIVERED
            $delivery->save();

            DB::commit();
            return redirect()->back()->with('success', 'Pesanan berhasil ditandai sebagai telah diantar. Menunggu konfirmasi pelanggan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menandai pesanan sebagai diantar: ' . $e->getMessage());
        }
    }
    
    // Courier history (completed/cancelled deliveries)
    public function history()
    {
        $user = Auth::user();
        $deliveries = Delivery::where('courier_id', $user->id)
                              ->whereIn('status', ['COMPLETED', 'CANCELLED'])
                              ->with(['order.canteen', 'order.customer', 'order.orderItems.menu'])
                              ->latest()
                              ->get();
        return view('courier.history', compact('deliveries'));
    }

    // Courier earnings
    public function earnings()
    {
        $user = Auth::user();
        $totalEarnings = Delivery::where('courier_id', $user->id)
                                 ->where('status', 'COMPLETED')
                                 ->sum('earnings');

        $completedDeliveries = Delivery::where('courier_id', $user->id)
                                       ->where('status', 'COMPLETED')
                                       ->with(['order.canteen', 'order.customer'])
                                       ->latest()
                                       ->get();

        return view('courier.earnings', compact('totalEarnings', 'completedDeliveries'));
    }

    // Toggle courier availability
    public function toggleAvailability()
    {
        $user = Auth::user();
        $user->courier_available = !$user->courier_available;
        $user->save();

        return redirect()->back()->with('success', 'Status ketersediaan kurir Anda telah diperbarui.');
    }
}
