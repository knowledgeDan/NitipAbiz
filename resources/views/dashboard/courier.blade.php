@extends('layouts.app')

@section('title', 'Dashboard Courier')
@section('page-title', 'Pengiriman')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <div class="mb-6">
            <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Siap Mengantar?</h3>
        <p class="text-gray-600 mb-6">Belum ada pesanan siap untuk diantar. Periksa kembali nanti.</p>
        
        @if(auth()->user()->courier_available)
            <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-lg">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Status: Tersedia
            </span>
        @else
            <span class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-800 rounded-lg">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                Status: Tidak Tersedia
            </span>
        @endif
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-3xl font-bold text-gray-800">0</div>
            <div class="text-sm text-gray-600 mt-1">Pengiriman Hari Ini</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-3xl font-bold text-gray-800">0</div>
            <div class="text-sm text-gray-600 mt-1">Total Pengiriman</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-3xl font-bold text-gray-800">Rp 0</div>
            <div class="text-sm text-gray-600 mt-1">Total Pendapatan</div>
        </div>
    </div>

    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
            <div>
                <p class="text-sm text-yellow-800 font-medium">Status Verifikasi Kurir</p>
                <p class="text-sm text-yellow-700 mt-1">{{ ucfirst(auth()->user()->courier_status) }} - Anda akan menerima notifikasi setelah diverifikasi.</p>
            </div>
        </div>
    </div>
</div>
@endsection
