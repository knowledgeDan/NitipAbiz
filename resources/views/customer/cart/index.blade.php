@extends('layouts.app')

@section('title', 'Keranjang Belanja')
@section('page-title', 'Keranjang Belanja')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Keranjang Belanja Anda</h1>

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

    @if (empty($cart))
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Keranjang Anda kosong.</h3>
            <p class="text-gray-600 mb-6">Tambahkan menu dari kantin untuk mulai memesan.</p>
            <a href="{{ route('canteens.index') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="lg:flex lg:space-x-6">
            <div class="lg:w-2/3">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6">
                        @foreach ($cart as $item)
                            <div class="flex items-center justify-between py-4 border-b last:border-b-0">
                                <div class="flex items-center">
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-800">{{ $item['name'] }}</h2>
                                        <p class="text-gray-600 text-sm">Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <form action="{{ route('cart.update', $item['menu_id']) }}" method="POST" class="flex items-center">
                                        @csrf
                                        <input type="hidden" name="_method" value="POST">
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" 
                                               class="w-16 text-center border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-gray-700">
                                        <button type="submit" class="ml-2 px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">Update</button>
                                    </form>
                                    <form action="{{ route('cart.remove', $item['menu_id']) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1H9a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="mt-6 flex justify-between">
                    <a href="{{ route('canteens.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                        Lanjut Belanja
                    </a>
                    <button class="px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                        Checkout
                    </button>
                </div>
            </div>

            <div class="lg:w-1/3 mt-6 lg:mt-0">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h2>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal Makanan:</span>
                        <span class="font-medium text-gray-800">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between mb-4">
                        <span class="text-gray-600">Biaya Pengiriman:</span>
                        <span class="font-medium text-gray-800">Rp{{ number_format(constant('App\Http\Controllers\CartController::DELIVERY_FEE'), 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-4 flex justify-between">
                        <span class="text-lg font-semibold text-gray-800">Total:</span>
                        <span class="text-lg font-bold text-orange-600">Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
