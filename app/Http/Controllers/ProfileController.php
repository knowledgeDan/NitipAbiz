<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\School;

class ProfileController extends Controller
{
    public function index()
    {
        $schools = School::where('status', 'active')->get();
        return view('profile.index', compact('schools'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'school_id' => ['required', 'exists:schools,id'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function applyCourier(Request $request)
    {
        $user = auth()->user();

        if ($user->courier_status !== 'not_courier') {
            return back()->withErrors(['error' => 'Anda sudah mengajukan atau menjadi kurir.']);
        }

        $validated = $request->validate([
            'student_id_photo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'face_photo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        if ($request->hasFile('student_id_photo')) {
            $studentIdPath = $request->file('student_id_photo')->store('courier-applications/student-id', 'private');
        }

        if ($request->hasFile('face_photo')) {
            $facePath = $request->file('face_photo')->store('courier-applications/face', 'private');
        }

        $user->update([
            'student_id_photo' => $studentIdPath ?? null,
            'face_photo' => $facePath ?? null,
            'courier_status' => 'courier_pending',
        ]);

        return back()->with('success', 'Pengajuan kurir berhasil! Menunggu verifikasi admin.');
    }
}
