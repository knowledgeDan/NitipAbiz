@extends('layouts.app')

@section('title', 'Daftar Kantin')
@section('page-title', 'Kantin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Kantin di Sekolah Anda</h1>

    @if ($canteens->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak ada kantin tersedia.</h3>
            <p class="text-gray-600 mb-6">Saat ini belum ada kantin yang terdaftar di sekolah Anda.</p>
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
                        <div class="text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-medium 
                                @if($canteen->status === 'active') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($canteen->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 px-6 py-4 bg-gray-50">
                        <a href="{{ route('menus.index', $canteen->id) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Lihat Menu &rarr;</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
