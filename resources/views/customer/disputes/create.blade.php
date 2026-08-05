@extends('layouts.app')

@section('title', 'Laporkan Sengketa')
@section('page-title', 'Laporkan Sengketa Pesanan #' . $order->id)

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Laporkan Sengketa untuk Pesanan #{{ $order->id }}</h1>

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-700 mb-4">Anda melaporkan masalah terkait pesanan dari Kantin <span class="font-medium">{{ $order->canteen->name }}</span>.</p>
        
        <form action="{{ route('disputes.store', $order->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Jenis Sengketa:</label>
                <select name="type" id="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('type') border-red-500 @enderror" required>
                    <option value="">-- Pilih Jenis Sengketa --</option>
                    @foreach ($disputeTypes as $type)
                        <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ ucfirst(strtolower(str_replace('_', ' ', $type))) }}</option>
                    @endforeach
                </select>
                @error('type')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Sengketa:</label>
                <textarea name="description" id="description" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror" placeholder="Jelaskan masalah Anda secara detail..." required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Kirim Laporan Sengketa
                </button>
                <a href="{{ route('dashboard') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
