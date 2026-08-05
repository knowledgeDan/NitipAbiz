@extends('layouts.app')

@section('title', 'Pengantaran Saya')
@section('page-title', 'Pengantaran Saya')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Pengantaran yang Sedang Berlangsung</h1>

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

    @if ($deliveries->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak ada pengantaran saat ini.</h3>
            <p class="text-gray-600 mb-6">Ambil pesanan dari daftar pesanan tersedia untuk mulai mengantar.</p>
            <a href="{{ route('courier.available-orders') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Lihat Pesanan Tersedia
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($deliveries as $delivery)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Pesanan #{{ $delivery->order->id }}</h2>
                    <p class="text-gray-700 mb-2">Dari: <span class="font-medium">{{ $delivery->order->canteen->name }}</span></p>
                    <p class="text-gray-700 mb-2">Untuk: <span class="font-medium">{{ $delivery->order->customer->name }}</span></p>
                    <p class="text-gray-700 mb-4">Status Pengantaran: 
                        <span class="px-3 py-1 rounded-full text-sm font-medium 
                            @if($delivery->status === 'DELIVERING') bg-yellow-100 text-yellow-800
                            @elseif($delivery->status === 'DELIVERED') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $delivery->status }}
                        </span>
                    </p>

                    <div class="border-t border-b border-gray-200 py-4 mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Detail Menu:</h3>
                        @foreach ($delivery->order->orderItems as $item)
                            <div class="flex justify-between text-gray-700 text-sm">
                                <span>{{ $item->quantity }} x {{ $item->menu->name }}</span>
                                <span>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between font-bold text-lg text-orange-600 mb-4">
                        <span>Fee Pengantaran:</span>
                        <span>Rp{{ number_format($delivery->earnings, 0, ',', '.') }}</span>
                    </div>

                    @if($delivery->status === 'DELIVERING')
                        <form action="{{ route('courier.mark-delivered', $delivery->order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                Tandai Sebagai Telah Diantar
                            </button>
                        </form>
                    @elseif($delivery->status === 'DELIVERED')
                        <p class="text-center text-gray-600">Menunggu konfirmasi penerimaan dari pelanggan.</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
