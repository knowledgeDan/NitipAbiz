@extends('layouts.app')

@section('title', 'Dashboard Customer')
@section('page-title', 'Pesanan')

@section('content')
@extends('layouts.app')

@section('title', 'Dashboard Customer')
@section('page-title', 'Pesanan')

@section('content')
<div class="max-w-4xl mx-auto">
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

    @if ($ongoingOrders->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <div class="mb-6">
                <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum ada pesanan aktif. Nitip yuk!</h3>
            <p class="text-gray-600 mb-6">Anda belum memiliki pesanan yang sedang berjalan. Mulai pesan makanan dari kantin sekolah Anda.</p>
            <a href="{{ route('canteens.index') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Lihat Kantin
            </a>
        </div>
    @else
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Pesanan Anda Saat Ini</h2>
        <div class="space-y-6">
            @foreach ($ongoingOrders as $order)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">Pesanan #{{ $order->id }}</h3>
                        <span class="px-3 py-1 rounded-full text-sm font-medium 
                            @if($order->status === 'COMPLETED') bg-green-100 text-green-800
                            @elseif($order->status === 'CANCELLED') bg-red-100 text-red-800
                            @elseif($order->status === 'DELIVERED') bg-purple-100 text-purple-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst(strtolower(str_replace('_', ' ', $order->status))) }}
                        </span>
                    </div>
                    <p class="text-gray-700 mb-2">Dari Kantin: <span class="font-medium">{{ $order->canteen->name }}</span></p>
                    <p class="text-gray-700 mb-4">Waktu Pesan: {{ $order->created_at->format('d M Y, H:i') }}</p>

                    <div class="border-t border-b border-gray-200 py-4 mb-4">
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Detail Item:</h4>
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
                        <span>Total Pembayaran:</span>
                        <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>

                    @if($order->status === 'DELIVERED')
                        <form action="{{ route('orders.confirm-receipt', $order->id) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                Konfirmasi Penerimaan Pesanan
                            </button>
                        </form>
                    @endif
                    @if($order->status === 'DELIVERED')
                        <a href="{{ route('disputes.create', $order->id) }}" class="mt-2 block w-full px-4 py-2 text-center bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                            Laporkan Sengketa
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

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
@endsection
