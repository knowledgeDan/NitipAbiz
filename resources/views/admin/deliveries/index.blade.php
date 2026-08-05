@extends('layouts.app')

@section('title', 'Monitor Pengantaran')
@section('page-title', 'Monitor Pengantaran')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Monitor Semua Pengantaran</h1>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="{{ route('admin.deliveries.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <div class="flex-grow">
                <label for="search" class="sr-only">Cari Pengantaran</label>
                <input type="text" name="search" id="search" placeholder="Cari ID pesanan, kurir, atau pelanggan..."
                       class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                       value="{{ request('search') }}">
            </div>
            <div>
                <label for="status" class="sr-only">Filter Berdasarkan Status</label>
                <select name="status" id="status" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                    <option value="all">Semua Status</option>
                    @foreach ($statuses as $status)
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
            <a href="{{ route('admin.deliveries.index') }}" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-100 transition-colors">
                Reset
            </a>
        </form>
    </div>

    @if ($deliveries->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak ada pengantaran ditemukan.</h3>
            <p class="text-gray-600 mb-6">Coba sesuaikan filter pencarian Anda.</p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID Pengantaran
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID Pesanan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kurir
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pelanggan
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
                            Pendapatan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Waktu Dibuat
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($deliveries as $delivery)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $delivery->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $delivery->order->id ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $delivery->courier->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $delivery->order->customer->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $delivery->order->canteen->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $delivery->order->canteen->school->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($delivery->status === 'COMPLETED') bg-green-100 text-green-800
                                    @elseif($delivery->status === 'DELIVERING') bg-blue-100 text-blue-800
                                    @elseif($delivery->status === 'DELIVERED') bg-purple-100 text-purple-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucfirst(strtolower(str_replace('_', ' ', $delivery->status))) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                Rp{{ number_format($delivery->earnings, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $delivery->created_at->format('d M Y H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $deliveries->links() }}
        </div>
    @endif
</div>
@endsection
