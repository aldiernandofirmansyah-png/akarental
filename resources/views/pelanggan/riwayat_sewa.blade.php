{{-- 
=================================================================
 FILE: pelanggan/riwayat_sewa.blade.php
 FUNGSI: Halaman untuk pelanggan melihat riwayat sewa sendiri
 FITUR: 
   - Tabel riwayat sewa pribadi
   - Status (Aktif/Selesai)
   - Info Denda (Flat 20rb/hari)
   - Tombol perpanjang untuk status Aktif
 DATA: Dikirim dari PelangganController (compact 'riwayatSaya')
=================================================================
--}}

@extends('layouts.app')

@section('title', 'Riwayat Sewa Saya | AKA Rental')

@section('sidebar_menu')
<li><a href="/pelanggan/dashboard" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition text-gray-700 font-medium"><i class="fas fa-tachometer-alt mr-3"></i> Dashboard</a></li>
<li><a href="/pelanggan/riwayat-sewa" class="block px-4 py-3 rounded-lg sidebar-active"><i class="fas fa-history mr-3"></i> Riwayat Sewa</a></li>
@endsection

@section('content')

{{-- ==================== HEADER SECTION ==================== --}}
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">
            Riwayat <span class="text-purple-600">Sewa Saya</span>
        </h1>
        <p class="text-gray-500 mt-1 font-medium">
            Pantau barang-barang yang sedang atau pernah Anda sewa.
        </p>
    </div>
</div>

{{-- ==================== INFO DENDA ==================== --}}
<div class="mb-6 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl">
    <div class="flex items-center">
        <i class="fas fa-circle-exclamation text-rose-500 text-xl mr-3"></i>
        <div>
            <p class="text-rose-800 font-bold text-sm">Informasi Denda Keterlambatan</p>
            <p class="text-rose-600 text-xs mt-0.5">Denda keterlambatan pengembalian flat <span class="font-bold">Rp 20.000 / hari</span> untuk semua kategori barang.</p>
        </div>
    </div>
</div>

{{-- ==================== TABEL RIWAYAT SEWA ==================== --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center bg-gray-50/50">
        <h2 class="text-xl font-bold text-gray-800 flex items-center">
            <span class="w-2 h-8 bg-purple-600 rounded-full mr-3"></span>
            Daftar Sewa Anda
        </h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-600 uppercase text-xs font-bold tracking-wider">
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Barang</th>
                    <th class="px-6 py-4">Periode</th>
                    <th class="px-6 py-4">Biaya Sewa</th>
                    <th class="px-6 py-4">Denda</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($riwayatSaya as $item)
                <tr class="hover:bg-purple-50/30 transition-colors duration-200 group">
                    <td class="px-6 py-4 font-bold text-gray-400">#{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-800">{{ $item->barang->nama_barang }}</div>
                        <div class="text-[10px] text-gray-400 font-medium">ID Transaksi: #AK{{ 1000 + $item->id }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-gray-700">{{ date('d M Y', strtotime($item->tanggal_mulai)) }}</span>
                            <span class="text-[10px] text-gray-400 font-medium">sampai {{ date('d M Y', strtotime($item->tanggal_kembali)) }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-700 text-sm">
                        Rp {{ number_format($item->total_biaya,0,',','.') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($item->denda > 0)
                            <div class="flex flex-col">
                                <span class="text-rose-600 font-bold text-sm">Rp {{ number_format($item->denda,0,',','.') }}</span>
                                <span class="text-[9px] text-rose-400 italic">({{ $item->denda / 20000 }} hari telat)</span>
                            </div>
                        @else
                            <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider
                            {{ $item->status_sewa == 'Aktif' ? 'bg-amber-100 text-amber-700 border border-amber-200' : ($item->status_sewa == 'Booking' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-green-100 text-green-700 border border-green-200') }}">
                            {{ $item->status_sewa }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($item->status_sewa == 'Aktif')
                            <button onclick="window.location.href='{{ route('pelanggan.perpanjangan', $item->id) }}'" class="text-[10px] font-bold bg-purple-600 text-white px-3 py-1.5 rounded-lg hover:bg-purple-700 transition shadow-md shadow-purple-100">
                                Perpanjang
                            </button>
                        @elseif($item->status_sewa == 'Booking')
                            <span class="text-[10px] text-blue-500 font-bold italic">Menunggu</span>
                        @else
                            <button class="text-[10px] font-bold bg-gray-100 text-gray-400 px-3 py-1.5 rounded-lg cursor-not-allowed">
                                Selesai
                            </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsectiondiv>

@endsection