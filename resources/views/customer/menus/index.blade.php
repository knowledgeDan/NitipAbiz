@extends('layouts.app')

@section('title', 'Daftar Menu')
@section('page-title', 'Menu ' . $canteen->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Menu dari {{ $canteen->name }}</h1>

    @if ($menus->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak ada menu tersedia.</h3>
            <p class="text-gray-600 mb-6">Saat ini kantin ini belum memiliki menu yang terdaftar.</p>
            <a href="{{ route('canteens.index') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Kembali ke Daftar Kantin
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($menus as $menu)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $menu->name }}</h2>
                        <p class="text-gray-600 text-sm mb-4">{{ $menu->description }}</p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-bold text-gray-900">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
                            <span class="text-sm text-gray-500">Stok: {{ $menu->stock }}</span>
                        </div>
                        <button class="add-to-cart-btn px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors"
                                data-menu-id="{{ $menu->id }}" data-canteen-id="{{ $canteen->id }}">
                            Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6 text-center">
            <a href="{{ route('canteens.index') }}" class="inline-block px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                Kembali ke Daftar Kantin
            </a>
        </div>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function() {
                const menuId = this.dataset.menuId;
                const canteenId = this.dataset.canteenId; // You might not need this in the actual add logic, but useful for context

                fetch('{{ url('cart/add') }}/' + menuId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ quantity: 1 }) // Always add 1 from this button
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        // Optionally update cart UI or redirect
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menambahkan ke keranjang.');
                });
            });
        });
    });
</script>
@endsection
