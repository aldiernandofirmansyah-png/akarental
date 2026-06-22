@extends('layouts.app')

@section('title', 'Riwayat Sewa | AKA Rental')

@section('content')

{{-- ==================== HEADER SECTION ==================== --}}
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">
        Riwayat <span class="text-purple-600">Sewa Selesai</span>
    </h1>
    <p class="text-gray-500 mt-1 font-medium">Daftar transaksi yang telah selesai.</p>
</div>

{{-- ==================== TABEL RIWAYAT ==================== --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-600 uppercase text-xs font-bold tracking-wider">
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4">Barang (Kode)</th>
                    <th class="px-6 py-4">Total Biaya</th>
                    <th class="px-6 py-4">Denda</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($riwayat as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-gray-400">#{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-bold text-gray-800">{{ $item->user->name }}</td>
                    <td class="px-6 py-4">{{ $item->barang->nama_barang }} <span class="text-purple-600 font-bold">({{ $item->kode_barang_fisik }})</span></td>
                    <td class="px-6 py-4 font-bold text-gray-800">Rp{{ number_format($item->total_biaya,0,',','.') }}</td>
                    <td class="px-6 py-4 font-bold text-red-600">Rp{{ number_format($item->denda,0,',','.') }}</td>
                    <td class="px-6 py-4 text-emerald-600 font-bold text-xs uppercase">{{ $item->status_sewa }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
