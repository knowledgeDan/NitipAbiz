@extends('layouts.app')

@section('title', 'Riwayat Pengantaran')
@section('page-title', 'Riwayat Pengantaran')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Riwayat Pengantaran Saya</h1>

    @if ($deliveries->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum ada riwayat pengantaran.</h3>
            <p class="text-gray-600 mb-6">Mulai mengantar pesanan untuk melihat riwayat Anda di sini.</p>
            <a href="{{ route('courier.available-orders') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Lihat Pesanan Tersedia
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($deliveries as $delivery)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Pengantaran #{{ $delivery->id }}</h2>
                    <p class="text-gray-700 mb-2">Pesanan #{{ $delivery->order->id }}</p>
                    <p class="text-gray-700 mb-2">Dari: <span class="font-medium">{{ $delivery->order->canteen->name }}</span></p>
                    <p class="text-gray-700 mb-2">Untuk: <span class="font-medium">{{ $delivery->order->customer->name }}</span></p>
                    <p class="text-gray-700 mb-4">Status: 
                        <span class="px-3 py-1 rounded-full text-sm font-medium 
                            @if($delivery->status === 'COMPLETED') bg-green-100 text-green-800
                            @elseif($delivery->status === 'CANCELLED') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $delivery->status }}
                        </span>
                    </p>
                    <p class="text-gray-700 text-sm">Tanggal: {{ $delivery->created_at->format('d M Y, H:i') }}</p>
                    <p class="text-gray-700 text-sm">Selesai: {{ $delivery->updated_at->format('d M Y, H:i') }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
