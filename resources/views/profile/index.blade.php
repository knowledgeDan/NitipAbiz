@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div class="max-w-4xl">
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Profile Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Profil</h3>
        
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', auth()->user()->name) }}"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', auth()->user()->email) }}"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div>
                    <label for="school_id" class="block text-sm font-medium text-gray-700 mb-1">Sekolah</label>
                    <select 
                        id="school_id" 
                        name="school_id" 
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    >
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}" {{ auth()->user()->school_id == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                    <input 
                        type="text" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone', auth()->user()->phone) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                @if(auth()->user()->nis)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
                    <input 
                        type="text" 
                        value="{{ auth()->user()->nis }}"
                        disabled
                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100"
                    >
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <input 
                        type="text" 
                        value="{{ ucfirst(auth()->user()->role) }}"
                        disabled
                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100"
                    >
                </div>
            </div>

            <div class="mt-6">
                <button 
                    type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Courier Application (Only for customers who are not couriers) -->
    @if(auth()->user()->role === 'customer' && auth()->user()->courier_status === 'not_courier')
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Daftar Jadi Kurir</h3>
        <p class="text-gray-600 mb-4">
            Dapatkan penghasilan tambahan dengan menjadi kurir pengiriman makanan di sekolah Anda. 
            Anda akan mendapatkan Rp 2.000 per pengiriman yang berhasil diselesaikan.
        </p>

        <form method="POST" action="{{ route('profile.apply-courier') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="student_id_photo" class="block text-sm font-medium text-gray-700 mb-1">
                        Foto Kartu Pelajar <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="file" 
                        id="student_id_photo" 
                        name="student_id_photo" 
                        accept="image/jpeg,image/png,image/jpg"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    >
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                </div>

                <div>
                    <label for="face_photo" class="block text-sm font-medium text-gray-700 mb-1">
                        Foto Wajah <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="file" 
                        id="face_photo" 
                        name="face_photo" 
                        accept="image/jpeg,image/png,image/jpg"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    >
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <p class="text-sm text-yellow-800 font-medium">Informasi Penting</p>
                            <p class="text-sm text-yellow-700 mt-1">
                                Foto akan dihapus setelah admin memverifikasi pengajuan Anda (diterima/ditolak). 
                                Pastikan foto jelas dan sesuai dengan identitas Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button 
                    type="submit"
                    class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors"
                >
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
    @elseif(auth()->user()->courier_status === 'courier_pending')
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Status Pengajuan Kurir</h3>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-sm text-yellow-800 font-medium">Pengajuan Sedang Diproses</p>
                    <p class="text-sm text-yellow-700 mt-1">
                        Pengajuan Anda sedang ditinjau oleh admin. Anda akan mendapatkan notifikasi setelah verifikasi selesai.
                    </p>
                </div>
            </div>
        </div>
    </div>
    @elseif(auth()->user()->courier_status === 'courier_verified')
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Status Kurir</h3>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-sm text-green-800 font-medium">Anda adalah Kurir Terverifikasi</p>
                    <p class="text-sm text-green-700 mt-1">
                        Anda dapat menerima dan mengirim pesanan. Penghasilan: Rp 2.000 per pengiriman.
                    </p>
                </div>
            </div>
        </div>
    </div>
    @elseif(auth()->user()->courier_status === 'courier_rejected')
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Status Pengajuan Kurir</h3>
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <div>
                    <p class="text-sm text-red-800 font-medium">Pengajuan Ditolak</p>
                    <p class="text-sm text-red-700 mt-1">
                        Mohon maaf, pengajuan kurir Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
