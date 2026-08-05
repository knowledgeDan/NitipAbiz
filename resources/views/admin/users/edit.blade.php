@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Pengguna')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Informasi Pengguna</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- User Info -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Dasar</h2>
                    <div>
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                        <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                        <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div>
                        <label for="nis" class="block text-gray-700 text-sm font-bold mb-2">NIS:</label>
                        <input type="text" name="nis" id="nis" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('nis', $user->nis) }}">
                    </div>
                    <div>
                        <label for="school_id" class="block text-gray-700 text-sm font-bold mb-2">Sekolah:</label>
                        <select name="school_id" id="school_id" class="w-full border border-gray-300 rounded px-3 py-2">
                            <option value="">-- Tidak Ada --</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}" {{ old('school_id', $user->school_id) == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Roles & Status -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Peran & Status</h2>
                    <div>
                        <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Peran:</label>
                        <select name="role" id="role" class="w-full border border-gray-300 rounded px-3 py-2">
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status Akun:</label>
                        <select name="status" id="status" class="w-full border border-gray-300 rounded px-3 py-2">
                            @foreach ($user_statuses as $status)
                                <option value="{{ $status }}" {{ old('status', $user->status) == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="verification_status" class="block text-gray-700 text-sm font-bold mb-2">Status Verifikasi:</label>
                        <select name="verification_status" id="verification_status" class="w-full border border-gray-300 rounded px-3 py-2">
                            @foreach ($verification_statuses as $status)
                                <option value="{{ $status }}" {{ old('verification_status', $user->verification_status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="courier_status" class="block text-gray-700 text-sm font-bold mb-2">Status Kurir:</label>
                        <select name="courier_status" id="courier_status" class="w-full border border-gray-300 rounded px-3 py-2">
                            @foreach ($courier_statuses as $status)
                                <option value="{{ $status }}" {{ old('courier_status', $user->courier_status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input type="hidden" name="courier_available" value="0">
                        <input type="checkbox" name="courier_available" id="courier_available" value="1" class="form-checkbox" {{ old('courier_available', $user->courier_available) ? 'checked' : '' }}>
                        <label for="courier_available" class="ml-2 block text-gray-700 text-sm font-bold">Kurir Tersedia</label>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
