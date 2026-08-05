@extends('layouts.app')

@section('title', 'Manajemen Menu')
@section('page-title', 'Menu Kantin: ' . $canteen->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Manajemen Menu untuk {{ $canteen->name }}</h1>

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

    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('seller.canteens.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
            &larr; Kembali ke Kantin
        </a>
        <a href="{{ route('seller.menus.create', $canteen->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            Tambah Menu Baru
        </a>
    </div>

    @if ($menus->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum ada menu di kantin ini.</h3>
            <p class="text-gray-600 mb-6">Tambahkan menu pertama Anda sekarang!</p>
            <a href="{{ route('seller.menus.create', $canteen->id) }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Tambah Menu
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($menus as $menu)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $menu->name }}</h2>
                        <p class="text-gray-600 text-sm mb-2">{{ $menu->description }}</p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-bold text-gray-900">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
                            <span class="text-sm text-gray-500">Stok: {{ $menu->stock }}</span>
                        </div>
                        <div class="text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-medium 
                                @if($menu->status === 'available') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                Status: {{ ucfirst($menu->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 px-6 py-4 bg-gray-50 flex justify-end space-x-2">
                        <a href="{{ route('seller.menus.edit', ['canteen' => $canteen->id, 'menu' => $menu->id]) }}" class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition-colors text-sm">Edit</a>
                        <form action="{{ route('seller.menus.destroy', ['canteen' => $canteen->id, 'menu' => $menu->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors text-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
