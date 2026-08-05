@extends('layouts.app')

@section('title', 'Checkout Pesanan')
@section('page-title', 'Checkout Pesanan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Checkout Pesanan Anda</h1>

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="lg:flex lg:space-x-6">
        <div class="lg:w-2/3">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Detail Pesanan</h2>
                <div class="mb-4">
                    <p class="text-gray-700">Kantin: <span class="font-medium">{{ $canteen->name }}</span></p>
                    <p class="text-gray-700">Lokasi: <span class="font-medium">{{ $canteen->location }}</span></p>
                </div>
                <div class="border-t border-b border-gray-200 py-4 mb-4">
                    @foreach ($cart as $item)
                        <div class="flex justify-between items-center py-2">
                            <div>
                                <p class="text-gray-800 font-medium">{{ $item['name'] }}</p>
                                <p class="text-gray-600 text-sm">{{ $item['quantity'] }} x Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                            <span class="text-gray-800 font-medium">Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between text-gray-700 mb-2">
                    <span>Subtotal Makanan:</span>
                    <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-700 mb-2">
                    <span>Biaya Pengiriman:</span>
                    <span>Rp{{ number_format(constant('App\Http\Controllers\CheckoutController::DELIVERY_FEE'), 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold text-lg text-gray-900">
                    <span>Total Pembayaran:</span>
                    <span class="text-orange-600">Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Metode Pembayaran</h2>
                <div class="flex items-center mb-4">
                    <input type="radio" id="cashPayment" name="paymentMethod" value="cash" class="form-radio h-4 w-4 text-blue-600" checked disabled>
                    <label for="cashPayment" class="ml-2 text-gray-700">Tunai (Cash)</label>
                </div>
                <p class="text-sm text-gray-600">Pembayaran akan dilakukan secara tunai kepada kurir saat pesanan diterima.</p>
            </div>
        </div>

        <div class="lg:w-1/3 mt-6 lg:mt-0">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Konfirmasi Pesanan</h2>
                <p class="text-gray-600 mb-4">Pastikan semua detail pesanan sudah benar sebelum melanjutkan.</p>
                <form action="{{ route('checkout.place-order') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                        Konfirmasi & Buat Pesanan
                    </button>
                </form>
                <a href="{{ route('cart.index') }}" class="block text-center mt-4 text-gray-600 hover:text-gray-800">
                    Kembali ke Keranjang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection