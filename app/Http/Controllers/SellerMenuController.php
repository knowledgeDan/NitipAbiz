<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerMenuController extends Controller
{
    private function checkCanteenOwnership(Canteen $canteen)
    {
        if ($canteen->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function index(Canteen $canteen)
    {
        $this->checkCanteenOwnership($canteen);
        $menus = $canteen->menus()->get();
        return view('seller.menus.index', compact('canteen', 'menus'));
    }

    public function create(Canteen $canteen)
    {
        $this->checkCanteenOwnership($canteen);
        return view('seller.menus.create', compact('canteen'));
    }

    public function store(Request $request, Canteen $canteen)
    {
        $this->checkCanteenOwnership($canteen);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:available,unavailable',
        ]);

        $canteen->menus()->create($request->all());

        return redirect()->route('seller.menus.index', $canteen->id)->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Canteen $canteen, Menu $menu)
    {
        $this->checkCanteenOwnership($canteen);
        if ($menu->canteen_id !== $canteen->id) {
            abort(404, 'Menu not found in this canteen.');
        }
        return view('seller.menus.edit', compact('canteen', 'menu'));
    }

    public function update(Request $request, Canteen $canteen, Menu $menu)
    {
        $this->checkCanteenOwnership($canteen);
        if ($menu->canteen_id !== $canteen->id) {
            abort(404, 'Menu not found in this canteen.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:available,unavailable',
        ]);

        $menu->update($request->all());

        return redirect()->route('seller.menus.index', $canteen->id)->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Canteen $canteen, Menu $menu)
    {
        $this->checkCanteenOwnership($canteen);
        if ($menu->canteen_id !== $canteen->id) {
            abort(404, 'Menu not found in this canteen.');
        }
        $menu->delete();
        return redirect()->route('seller.menus.index', $canteen->id)->with('success', 'Menu berhasil dihapus.');
    }
}
