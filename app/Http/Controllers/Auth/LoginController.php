<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\School;

class LoginController extends Controller
{
    public function showUserLoginForm()
    {
        $schools = School::where('status', 'active')->get();
        return view('auth.login-user', compact('schools'));
    }

    public function showSellerLoginForm()
    {
        $schools = School::where('status', 'active')->get();
        return view('auth.login-seller', compact('schools'));
    }

    public function loginUser(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'school_id' => ['required', 'exists:schools,id'],
        ]);

        $email = $credentials['email'];
        $password = $credentials['password'];
        $schoolId = $credentials['school_id'];

        if (Auth::attempt(['email' => $email, 'password' => $password], $request->boolean('remember'))) {
            $user = Auth::user();
            
            if (!in_array($user->role, ['customer', 'courier'])) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan akun siswa. Silakan gunakan login penjual.',
                ])->onlyInput('email');
            }

            $user->update(['school_id' => $schoolId]);
            
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function loginSeller(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'school_id' => ['required', 'exists:schools,id'],
        ]);

        $email = $credentials['email'];
        $password = $credentials['password'];
        $schoolId = $credentials['school_id'];

        if (Auth::attempt(['email' => $email, 'password' => $password], $request->boolean('remember'))) {
            $user = Auth::user();
            
            if ($user->role !== 'seller') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan akun penjual. Silakan gunakan login siswa.',
                ])->onlyInput('email');
            }

            $user->update(['school_id' => $schoolId]);
            
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
