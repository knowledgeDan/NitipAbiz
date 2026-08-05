<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = User::with('school');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
        }

        if ($request->has('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        if ($request->has('school_id') && $request->school_id !== 'all') {
            $query->where('school_id', $request->school_id);
        }

        $users = $query->paginate(10);
        $schools = School::all(); // For filter dropdown

        return view('admin.users.index', compact('users', 'schools'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $schools = School::all();
        $roles = ['customer', 'seller', 'courier', 'system_manager'];
        $user_statuses = ['active', 'inactive', 'suspended'];
        $verification_statuses = ['UNVERIFIED', 'PENDING_REVIEW', 'VERIFIED', 'REJECTED', 'SUSPENDED'];
        $courier_statuses = ['COURIER_PENDING', 'COURIER_VERIFIED', 'COURIER_REJECTED', 'COURIER_SUSPENDED'];
        return view('admin.users.edit', compact('user', 'schools', 'roles', 'user_statuses', 'verification_statuses', 'courier_statuses'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'nis' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:255'],
            'school_id' => 'nullable|exists:schools,id',
            'role' => ['required', Rule::in(['customer', 'seller', 'courier', 'system_manager'])],
            'status' => ['required', Rule::in(['active', 'inactive', 'suspended'])],
            'verification_status' => ['required', Rule::in(['UNVERIFIED', 'PENDING_REVIEW', 'VERIFIED', 'REJECTED', 'SUSPENDED'])],
            'courier_status' => ['required', Rule::in(['COURIER_PENDING', 'COURIER_VERIFIED', 'COURIER_REJECTED', 'COURIER_SUSPENDED'])],
            'courier_available' => 'boolean',
        ]);

        $user->update($request->all());

        return redirect()->route('admin.users.index')->with('success', 'Informasi pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
