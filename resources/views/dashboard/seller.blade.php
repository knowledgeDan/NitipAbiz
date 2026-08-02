@extends('layouts.app')

@section('title', 'Dashboard Seller')
@section('page-title', 'Kantin Saya')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <div class="mb-6">
            <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Kelola Kantin Anda</h3>
        <p class="text-gray-600 mb-6">Daftarkan kantin Anda untuk mulai menerima pesanan dari siswa.</p>
        <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            Daftarkan Kantin
        </button>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-3xl font-bold text-gray-800">0</div>
            <div class="text-sm text-gray-600 mt-1">Total Pesanan</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-3xl font-bold text-gray-800">0</div>
            <div class="text-sm text-gray-600 mt-1">Menu Aktif</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-3xl font-bold text-gray-800">Rp 0</div>
            <div class="text-sm text-gray-600 mt-1">Total Pendapatan</div>
        </div>
    </div>
</div>
@endsection
