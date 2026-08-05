@extends('layouts.app')

@section('title', 'Edit Kantin')
@section('page-title', 'Edit Kantin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Informasi Kantin</h1>

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

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.canteens.update', $canteen->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Kantin:</label>
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name', $canteen->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="owner_id" class="block text-gray-700 text-sm font-bold mb-2">Pemilik Kantin (ID Pengguna):</label>
                <input type="number" name="owner_id" id="owner_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('owner_id') border-red-500 @enderror" value="{{ old('owner_id', $canteen->owner_id) }}" required>
                @error('owner_id')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="school_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Sekolah:</label>
                <select name="school_id" id="school_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('school_id') border-red-500 @enderror" required>
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}" {{ old('school_id', $canteen->school_id) == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                    @endforeach
                </select>
                @error('school_id')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Lokasi:</label>
                <input type="text" name="location" id="location" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('location') border-red-500 @enderror" value="{{ old('location', $canteen->location) }}" required>
                @error('location')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi (Opsional):</label>
                <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror">{{ old('description', $canteen->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status') border-red-500 @enderror" required>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ old('status', $canteen->status) == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                @error('status')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Perbarui Kantin
                </button>
                <a href="{{ route('admin.canteens.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
