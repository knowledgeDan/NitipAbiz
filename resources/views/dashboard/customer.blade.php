@extends('layouts.app')

@section('title', 'Dashboard Customer')
@section('page-title', 'Pesanan')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <div class="mb-6">
            <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum pesan. Nitip yuk!</h3>
        <p class="text-gray-600 mb-6">Anda belum memiliki pesanan. Mulai pesan makanan dari kantin sekolah Anda.</p>
        <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            Lihat Kantin
        </button>
    </div>

    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
            <div>
                <p class="text-sm text-blue-800 font-medium">Selamat datang di NitipAbiz!</p>
                <p class="text-sm text-blue-700 mt-1">Status akun: <span class="font-semibold">{{ ucfirst(auth()->user()->verification_status) }}</span></p>
            </div>
        </div>
    </div>
</div>
@endsection
