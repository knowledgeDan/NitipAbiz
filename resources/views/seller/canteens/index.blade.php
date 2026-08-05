@extends('layouts.app')

@section('title', 'Kantin Saya')
@section('page-title', 'Kantin Saya')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Manajemen Kantin Saya</h1>

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

    <div class="flex justify-end mb-4">
        <a href="{{ route('seller.canteens.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            Tambah Kantin Baru
        </a>
    </div>

    @if ($canteens->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Anda belum memiliki kantin.</h3>
            <p class="text-gray-600 mb-6">Daftarkan kantin Anda untuk mulai berjualan.</p>
            <a href="{{ route('seller.canteens.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Daftarkan Kantin Sekarang
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($canteens as $canteen)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $canteen->name }}</h2>
                        <p class="text-gray-600 text-sm mb-4">{{ $canteen->description }}</p>
                        <div class="flex items-center text-gray-700 text-sm mb-2">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>{{ $canteen->location }}</span>
                        </div>
                        <p class="text-gray-700 text-sm mb-2">Sekolah: <span class="font-medium">{{ $canteen->school->name }}</span></p>
                        <div class="text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-medium 
                                @if($canteen->status === 'active') bg-green-100 text-green-800
                                @elseif($canteen->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                Status: {{ ucfirst($canteen->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 px-6 py-4 bg-gray-50 flex justify-end space-x-2">
                        <a href="{{ route('seller.canteens.edit', $canteen->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition-colors text-sm">Edit</a>
                        <form action="{{ route('seller.canteens.destroy', $canteen->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kantin ini?');">
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