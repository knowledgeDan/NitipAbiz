@extends('layouts.app')

@section('title', 'Pendapatan Kurir')
@section('page-title', 'Pendapatan Kurir')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Pendapatan Saya</h1>

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

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Total Pendapatan</h2>
        <p class="text-5xl font-bold text-orange-600 mb-4">Rp{{ number_format($totalEarnings, 0, ',', '.') }}</p>
        <p class="text-gray-600">Ini adalah total pendapatan dari semua pengantaran yang berhasil diselesaikan.</p>
    </div>

    <h2 class="text-2xl font-bold text-gray-800 mb-4">Riwayat Pengantaran Selesai</h2>

    @if ($completedDeliveries->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum ada pengantaran yang diselesaikan.</h3>
            <p class="text-gray-600 mb-6">Selesaikan pengantaran untuk melihat riwayat pendapatan Anda.</p>
            <a href="{{ route('courier.available-orders') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Lihat Pesanan Tersedia
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($completedDeliveries as $delivery)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Pengantaran #{{ $delivery->id }}</h3>
                    <p class="text-gray-700 mb-2">Pesanan #{{ $delivery->order->id }}</p>
                    <p class="text-gray-700 mb-2">Dari: <span class="font-medium">{{ $delivery->order->canteen->name }}</span></p>
                    <p class="text-gray-700 mb-2">Untuk: <span class="font-medium">{{ $delivery->order->customer->name }}</span></p>
                    <p class="text-gray-700 mb-4">Tanggal Selesai: {{ $delivery->updated_at->format('d M Y, H:i') }}</p>
                    <div class="flex justify-between font-bold text-lg text-green-600">
                        <span>Pendapatan:</span>
                        <span>Rp{{ number_format($delivery->earnings, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
