<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    const DELIVERY_FEE = 2000;

    public function index()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $total = $subtotal + self::DELIVERY_FEE;

        // All items in cart must be from the same canteen, so just get the first one's canteen_id
        $canteenId = reset($cart)['canteen_id'];
        $canteen = Canteen::find($canteenId);

        if (!$canteen) {
            Session::forget('cart');
            return redirect()->route('cart.index')->with('error', 'Kantin tidak ditemukan.');
        }

        return view('customer.checkout.index', compact('cart', 'subtotal', 'total', 'canteen'));
    }

    public function placeOrder(Request $request)
    {
        $user = Auth::user();
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Validate stock before placing order
        foreach ($cart as $itemId => $item) {
            $menu = Menu::find($itemId);
            if (!$menu || $menu->stock < $item['quantity']) {
                return redirect()->route('cart.index')->with('error', 'Stok ' . $menu->name . ' tidak mencukupi.');
            }
        }

        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $total = $subtotal + self::DELIVERY_FEE;
        $canteenId = reset($cart)['canteen_id'];

        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_id' => $user->id,
                'canteen_id' => $canteenId,
                'status' => 'PENDING',
                'subtotal' => $subtotal,
                'delivery_fee' => self::DELIVERY_FEE,
                'total' => $total,
            ]);

            foreach ($cart as $itemId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $itemId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                // Deduct stock
                $menu = Menu::find($itemId);
                $menu->stock -= $item['quantity'];
                $menu->save();
            }

            Session::forget('cart');
            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Pesanan Anda berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage());
        }
    }
}
