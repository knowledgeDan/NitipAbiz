@extends('layouts.app')

@section('title', 'Manajemen Sengketa')
@section('page-title', 'Manajemen Sengketa')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Manajemen Sengketa</h1>

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
        <form action="{{ route('admin.disputes.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <div class="flex-grow">
                <label for="search" class="sr-only">Cari Sengketa</label>
                <input type="text" name="search" id="search" placeholder="Cari ID sengketa, pesanan, pelanggan, atau kurir..."
                       class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                       value="{{ request('search') }}">
            </div>
            <div>
                <label for="type" class="sr-only">Filter Berdasarkan Jenis</label>
                <select name="type" id="type" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                    <option value="all">Semua Jenis</option>
                    @foreach ($disputeTypes as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst(strtolower(str_replace('_', ' ', $type))) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status" class="sr-only">Filter Berdasarkan Status</label>
                <select name="status" id="status" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                    <option value="all">Semua Status</option>
                    @foreach ($disputeStatuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst(strtolower(str_replace('_', ' ', $status))) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="school_id" class="sr-only">Filter Berdasarkan Sekolah</label>
                <select name="school_id" id="school_id" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                    <option value="all">Semua Sekolah</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                Filter
            </button>
            <a href="{{ route('admin.disputes.index') }}" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-100 transition-colors">
                Reset
            </a>
        </form>
    </div>

    @if ($disputes->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak ada sengketa ditemukan.</h3>
            <p class="text-gray-600 mb-6">Coba sesuaikan filter pencarian Anda.</p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID Sengketa
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jenis
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID Pesanan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pelapor
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kantin
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sekolah
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($disputes as $dispute)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $dispute->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ ucfirst(strtolower(str_replace('_', ' ', $dispute->type))) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $dispute->order->id ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $dispute->customer->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $dispute->order->canteen->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $dispute->order->canteen->school->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($dispute->status === 'RESOLVED') bg-green-100 text-green-800
                                    @elseif($dispute->status === 'REJECTED') bg-red-100 text-red-800
                                    @elseif($dispute->status === 'PENDING') bg-yellow-100 text-yellow-800
                                    @else bg-blue-100 text-blue-800
                                    @endif">
                                    {{ ucfirst(strtolower(str_replace('_', ' ', $dispute->status))) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $dispute->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('admin.disputes.update-status', $dispute->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @if ($dispute->status === 'PENDING')
                                        <button type="submit" name="status" value="IN_REVIEW" class="text-blue-600 hover:text-blue-900 mr-3">Tinjau</button>
                                    @elseif ($dispute->status === 'IN_REVIEW')
                                        <button type="submit" name="status" value="RESOLVED" class="text-green-600 hover:text-green-900 mr-3">Selesaikan</button>
                                        <button type="submit" name="status" value="REJECTED" class="text-red-600 hover:text-red-900">Tolak</button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $disputes->links() }}
        </div>
    @endif
</div>
@endsection
