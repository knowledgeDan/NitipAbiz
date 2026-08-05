@extends('layouts.app')

@section('title', 'Riwayat Pesanan')
@section('page-title', 'Riwayat Pesanan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Riwayat Pesanan Anda</h1>

    @if ($orders->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum ada riwayat pesanan.</h3>
            <p class="text-gray-600 mb-6">Anda belum pernah melakukan pemesanan. Mulai belanja sekarang!</p>
            <a href="{{ route('canteens.index') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach ($orders as $order)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">Pesanan #{{ $order->id }}</h2>
                        <span class="px-3 py-1 rounded-full text-sm font-medium 
                            @if($order->status === 'COMPLETED') bg-green-100 text-green-800
                            @elseif($order->status === 'CANCELLED') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $order->status }}
                        </span>
                    </div>
                    <p class="text-gray-700 mb-2">Kantin: <span class="font-medium">{{ $order->canteen->name }}</span></p>
                    <p class="text-gray-700 mb-4">Tanggal: {{ $order->created_at->format('d M Y, H:i') }}</p>

                    <div class="border-t border-b border-gray-200 py-4 mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Detail Pesanan:</h3>
                        @foreach ($order->orderItems as $item)
                            <div class="flex justify-between text-gray-700 text-sm">
                                <span>{{ $item->quantity }} x {{ $item->menu->name }}</span>
                                <span>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-between text-gray-700 mb-2">
                        <span>Subtotal Makanan:</span>
                        <span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-700 mb-2">
                        <span>Biaya Pengiriman:</span>
                        <span>Rp{{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg text-gray-900">
                        <span>Total:</span>
                        <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
