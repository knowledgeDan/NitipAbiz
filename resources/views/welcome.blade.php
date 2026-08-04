@extends('layouts.guest')

@section('title', 'Selamat Datang')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-4xl w-full text-center">
        <!-- Logo/Brand -->
        <div class="mb-8">
            <h1 class="text-6xl font-bold text-blue-600 mb-4">NitipAbiz</h1>
            <p class="text-xl text-gray-600">Platform Pemesanan & Pengiriman Makanan Sekolah</p>
        </div>

        <!-- Description -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Pesan Makanan</h3>
                    <p class="text-sm text-gray-600">Pesan makanan dari kantin sekolah dengan mudah</p>
                </div>

                <div class="text-center">
                    <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Pengiriman Cepat</h3>
                    <p class="text-sm text-gray-600">Kurir sekolah antar langsung ke kelas Anda</p>
                </div>

                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Aman & Terpercaya</h3>
                    <p class="text-sm text-gray-600">Verifikasi NIS untuk keamanan siswa</p>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login.user') }}" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        Masuk Sebagai Siswa
                    </a>
                    <a href="{{ route('login.seller') }}" class="px-8 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors font-medium">
                        Masuk Sebagai Penjual
                    </a>
                    <a href="{{ route('register') }}" class="px-8 py-3 bg-white border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                        Daftar Sekarang
                    </a>
                @endauth
            </div>
        </div>

        <!-- Footer Info -->
        <p class="text-sm text-gray-500">
            Platform pemesanan makanan khusus untuk siswa sekolah di Indonesia
        </p>
    </div>
</div>
@endsection
