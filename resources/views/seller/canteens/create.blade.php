@extends('layouts.app')

@section('title', 'Tambah Kantin')
@section('page-title', 'Tambah Kantin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Daftarkan Kantin Baru</h1>

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('seller.canteens.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Kantin:</label>
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="school_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Sekolah:</label>
                <select name="school_id" id="school_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('school_id') border-red-500 @enderror" required>
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                    @endforeach
                </select>
                @error('school_id')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Lokasi (contoh: Gedung A lantai 1):</label>
                <input type="text" name="location" id="location" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('location') border-red-500 @enderror" value="{{ old('location') }}" required>
                @error('location')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi (Opsional):</label>
                <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Daftarkan Kantin
                </button>
                <a href="{{ route('seller.canteens.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
