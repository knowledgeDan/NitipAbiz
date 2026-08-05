<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    const DELIVERY_FEE = 2000; // Fixed delivery fee as per PRD

    public function index()
    {
        $cart = Session::get('cart', []);
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $total = $subtotal + (count($cart) > 0 ? self::DELIVERY_FEE : 0);

        return view('customer.cart.index', compact('cart', 'subtotal', 'total'));
    }

    public function add(Request $request, Menu $menu)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);
        $canteenId = $menu->canteen_id;

        // Ensure all items in the cart are from the same canteen
        foreach ($cart as $item) {
            if ($item['canteen_id'] !== $canteenId) {
                return redirect()->back()->with('error', 'Anda hanya dapat memesan dari satu kantin dalam satu waktu.');
            }
        }

        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['quantity'] += $request->quantity;
        } else {
            $cart[$menu->id] = [
                'menu_id' => $menu->id,
                'canteen_id' => $menu->canteen_id,
                'name' => $menu->name,
                'price' => $menu->price,
                'quantity' => $request->quantity,
            ];
        }

        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);
        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Jumlah menu berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Menu tidak ditemukan di keranjang.');
    }

    public function remove(Menu $menu)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$menu->id])) {
            unset($cart[$menu->id]);
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Menu berhasil dihapus dari keranjang.');
        }

        return redirect()->back()->with('error', 'Menu tidak ditemukan di keranjang.');
    }
}
