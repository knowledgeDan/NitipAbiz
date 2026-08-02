<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use App\Models\StudentRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $schools = School::where('status', 'active')->get();
        return view('auth.register', compact('schools'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'school_id' => ['required', 'exists:schools,id'],
            'nis' => ['required', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $student = StudentRegistry::where('school_id', $validated['school_id'])
            ->where('nis', $validated['nis'])
            ->first();

        if (!$student) {
            return back()->withErrors([
                'nis' => 'NIS tidak terdaftar di sekolah ini. Hubungi admin sekolah Anda.',
            ])->withInput();
        }

        if ($student->is_registered) {
            return back()->withErrors([
                'nis' => 'NIS ini sudah terdaftar. Gunakan NIS lain atau hubungi admin.',
            ])->withInput();
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'school_id' => $validated['school_id'],
            'nis' => $validated['nis'],
            'phone' => $validated['phone'],
            'role' => 'customer',
            'status' => 'active',
            'verification_status' => 'unverified',
        ]);

        $student->update(['is_registered' => true]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
