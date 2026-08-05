<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerCanteenController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $canteens = Canteen::where('owner_id', $user->id)->get();
        return view('seller.canteens.index', compact('canteens'));
    }

    public function create()
    {
        $schools = School::all();
        return view('seller.canteens.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'school_id' => 'required|exists:schools,id',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Canteen::create([
            'owner_id' => Auth::id(),
            'school_id' => $request->school_id,
            'name' => $request->name,
            'location' => $request->location,
            'description' => $request->description,
            'status' => 'pending', // Canteen may require System Manager verification
        ]);

        return redirect()->route('seller.canteens.index')->with('success', 'Kantin berhasil didaftarkan. Menunggu verifikasi.');
    }

    public function edit(Canteen $canteen)
    {
        if ($canteen->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $schools = School::all();
        return view('seller.canteens.edit', compact('canteen', 'schools'));
    }

    public function update(Request $request, Canteen $canteen)
    {
        if ($canteen->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'school_id' => 'required|exists:schools,id',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $canteen->update([
            'school_id' => $request->school_id,
            'name' => $request->name,
            'location' => $request->location,
            'description' => $request->description,
        ]);

        return redirect()->route('seller.canteens.index')->with('success', 'Informasi kantin berhasil diperbarui.');
    }

    public function destroy(Canteen $canteen)
    {
        if ($canteen->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $canteen->delete();
        return redirect()->route('seller.canteens.index')->with('success', 'Kantin berhasil dihapus.');
    }
}
