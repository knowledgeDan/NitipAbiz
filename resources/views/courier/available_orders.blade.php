@extends('layouts.app')

@section('title', 'Pesanan Tersedia')
@section('page-title', 'Pesanan Tersedia')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Pesanan Tersedia untuk Diambil</h1>

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
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Status Ketersediaan Anda</h2>
        <div class="flex items-center justify-between">
            <p class="text-gray-700">
                Saat ini Anda: 
                <span class="font-bold @if(auth()->user()->courier_available) text-green-600 @else text-red-600 @endif">
                    {{ auth()->user()->courier_available ? 'TERSEDIA' : 'TIDAK TERSEDIA' }}
                </span>
            </p>
            <form action="{{ route('courier.toggle-availability') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 
                    @if(auth()->user()->courier_available) bg-red-600 hover:bg-red-700 
                    @else bg-green-600 hover:bg-green-700 @endif 
                    text-white rounded-lg transition-colors">
                    {{ auth()->user()->courier_available ? 'Set Tidak Tersedia' : 'Set Tersedia' }}
                </button>
            </form>
        </div>
        @if(auth()->user()->courier_status !== 'VERIFIED')
            <p class="text-red-500 text-sm mt-2">Anda belum diverifikasi sebagai kurir. Mohon lengkapi proses verifikasi di profil Anda.</p>
        @endif
    </div>

    @if($ongoingDelivery)
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-6" role="alert">
            <h2 class="font-bold">Pengantaran Sedang Berlangsung</h2>
            <p>Anda sedang mengantar Pesanan #{{ $ongoingDelivery->order->id }} dari {{ $ongoingDelivery->order->canteen->name }} untuk {{ $ongoingDelivery->order->customer->name }}.</p>
            <p class="mt-2">Silakan selesaikan pengantaran Anda saat ini sebelum mengambil pesanan lain.</p>
            <a href="{{ route('courier.deliveries') }}" class="font-semibold underline mt-2 inline-block">Lihat Detail Pengantaran</a>
        </div>
    @endif

    @if ($availableOrders->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak ada pesanan tersedia saat ini.</h3>
            <p class="text-gray-600 mb-6">Periksa kembali nanti atau pastikan Anda sudah <span class="font-medium text-green-600">TERSEDIA</span>.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($availableOrders as $order)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Pesanan #{{ $order->id }}</h2>
                    <p class="text-gray-700 mb-2">Dari: <span class="font-medium">{{ $order->canteen->name }}</span></p>
                    <p class="text-gray-700 mb-2">Tujuan: <span class="font-medium">{{ $order->customer->name }} (Lokasi Pengantaran)</span></p>
                    <div class="border-t border-b border-gray-200 py-4 mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Detail Menu:</h3>
                        @foreach ($order->orderItems as $item)
                            <div class="flex justify-between text-gray-700 text-sm">
                                <span>{{ $item->quantity }} x {{ $item->menu->name }}</span>
                                <span>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between font-bold text-lg text-orange-600 mb-4">
                        <span>Fee Pengantaran:</span>
                        <span>Rp{{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                    </div>
                    <form action="{{ route('courier.accept-order', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                            @if(auth()->user()->courier_status !== 'VERIFIED' || !auth()->user()->courier_available || $ongoingDelivery) disabled @endif>
                            Ambil Pesanan
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
