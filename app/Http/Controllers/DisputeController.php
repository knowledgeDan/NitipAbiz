<?php

namespace App\Http\Controllers;

use App\Models\Dispute;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DisputeController extends Controller
{
    /**
     * Show the form for creating a new dispute.
     *
     * @param  \App\Models\Order  $order The order for which the dispute is being created.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(Order $order)
    {
        // Ensure the authenticated user is the customer of the order
        if ($order->customer_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk membuat sengketa untuk pesanan ini.');
        }

        // Check if a dispute for this order already exists
        if (Dispute::where('order_id', $order->id)->exists()) {
            return redirect()->back()->with('error', 'Sengketa untuk pesanan ini sudah ada.');
        }

        // Define possible dispute types as per PRD
        $disputeTypes = [
            'PAYMENT_DISPUTED',
            'DELIVERY_DISPUTED',
            'ORDER_NOT_RECEIVED',
            'INCORRECT_ORDER',
            'OTHER_ISSUE',
        ];

        return view('customer.disputes.create', compact('order', 'disputeTypes'));
    }

    /**
     * Store a newly created dispute in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order The order for which the dispute is being stored.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Order $order)
    {
        // Ensure the authenticated user is the customer of the order
        if ($order->customer_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk membuat sengketa untuk pesanan ini.');
        }

        // Check if a dispute for this order already exists
        if (Dispute::where('order_id', $order->id)->exists()) {
            return redirect()->back()->with('error', 'Sengketa untuk pesanan ini sudah ada.');
        }

        $request->validate([
            'type' => ['required', Rule::in([
                'PAYMENT_DISPUTED',
                'DELIVERY_DISPUTED',
                'ORDER_NOT_RECEIVED',
                'INCORRECT_ORDER',
                'OTHER_ISSUE',
            ])],
            'description' => 'required|string|max:1000',
        ]);

        Dispute::create([
            'order_id' => $order->id,
            'customer_id' => Auth::id(), // The customer who reported the dispute
            'type' => $request->type,
            'description' => $request->description,
            'status' => 'PENDING', // Initial status for a new dispute
        ]);

        return redirect()->route('dashboard')->with('success', 'Sengketa Anda berhasil dilaporkan. Kami akan segera meninjaunya.');
    }
}
