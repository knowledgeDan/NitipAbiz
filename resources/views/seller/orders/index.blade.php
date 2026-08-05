@extends('layouts.app')

@section('title', 'Manajemen Pesanan')
@section('page-title', 'Pesanan Masuk')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Pesanan Masuk</h1>

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

    @if ($orders->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak ada pesanan masuk.</h3>
            <p class="text-gray-600 mb-6">Saat ini belum ada pesanan yang perlu Anda proses.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($orders as $order)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">Pesanan #{{ $order->id }}</h2>
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            {{ $order->status }}
                        </span>
                    </div>
                    <p class="text-gray-700 mb-2">Pelanggan: <span class="font-medium">{{ $order->customer->name }}</span></p>
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
                    <div class="flex justify-between font-bold text-lg text-gray-900 mb-4">
                        <span>Total:</span>
                        <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Aksi:</h3>
                        <form action="{{ route('seller.orders.update-status', $order->id) }}" method="POST" class="space-y-2">
                            @csrf
                            @if ($order->status === 'PENDING')
                                <button type="submit" name="status" value="ACCEPTED" class="w-full px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                    Terima Pesanan
                                </button>
                                <button type="submit" name="status" value="CANCELLED" class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                    Batalkan Pesanan
                                </button>
                            @elseif ($order->status === 'ACCEPTED')
                                <button type="submit" name="status" value="PREPARING" class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                    Mulai Siapkan
                                </button>
                            @elseif ($order->status === 'PREPARING')
                                <button type="submit" name="status" value="READY_FOR_PICKUP" class="w-full px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                                    Siap Diambil Kurir
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
