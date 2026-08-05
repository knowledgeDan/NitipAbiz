@extends('layouts.app')

@section('title', 'Laporan & Statistik')
@section('page-title', 'Laporan & Statistik')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Laporan dan Statistik Platform</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
        <!-- Total Users Card -->
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <h2 class="text-lg font-semibold text-gray-600 mb-2">Total Pengguna</h2>
            <p class="text-5xl font-bold text-blue-600">{{ $totalUsers }}</p>
        </div>

        <!-- Total Schools Card -->
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <h2 class="text-lg font-semibold text-gray-600 mb-2">Total Sekolah</h2>
            <p class="text-5xl font-bold text-green-600">{{ $totalSchools }}</p>
        </div>

        <!-- Total Canteens Card -->
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <h2 class="text-lg font-semibold text-gray-600 mb-2">Total Kantin</h2>
            <p class="text-5xl font-bold text-yellow-600">{{ $totalCanteens }}</p>
        </div>

        <!-- Total Orders Card -->
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <h2 class="text-lg font-semibold text-gray-600 mb-2">Total Pesanan</h2>
            <p class="text-5xl font-bold text-indigo-600">{{ $totalOrders }}</p>
        </div>

        <!-- Total Deliveries Card -->
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <h2 class="text-lg font-semibold text-gray-600 mb-2">Total Pengantaran</h2>
            <p class="text-5xl font-bold text-red-600">{{ $totalDeliveries }}</p>
        </div>
    </div>

    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
            <div>
                <p class="text-sm text-blue-800 font-medium">Informasi ini adalah ringkasan cepat aktivitas platform. Untuk laporan yang lebih detail, akan dikembangkan pada versi mendatang.</p>
            </div>
        </div>
    </div>
</div>
@endsection
