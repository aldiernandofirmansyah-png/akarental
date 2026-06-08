{{-- 
=================================================================
 FILE: admin/data_pelanggan.blade.php
 FUNGSI: Halaman untuk admin melihat data pelanggan
 FITUR: 
   - Tabel daftar pelanggan
   - Status booking (Aktif/Selesai)
   - Total bayar dan denda
 DATA: Dikirim dari AdminController (compact 'pelanggans')
=================================================================
--}}

@extends('layouts.app')

@section('title', 'Data Pelanggan | AKA Rental')

@section('sidebar_menu')
<li><a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition text-gray-700 font-medium"><i class="fas fa-tachometer-alt mr-3"></i> Dashboard</a></li>
<li><a href="{{ route('admin.data_pelanggan') }}" class="block px-4 py-3 rounded-lg sidebar-active"><i class="fas fa-users mr-3"></i> Data Pelanggan</a></li>
<li><a href="{{ route('admin.riwayat_sewa') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition text-gray-700 font-medium"><i class="fas fa-history mr-3"></i> Riwayat Sewa</a></li>
@endsection

@section('content')

{{-- ==================== HEADER SECTION ==================== --}}
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">
            Data <span class="text-purple-600">Pelanggan</span>
        </h1>
        <p class="text-gray-500 mt-1 font-medium">
            Kelola dan pantau informasi pelanggan setia AKA Rental.
        </p>
    </div>
</div>

{{-- ==================== TABEL DATA PELANGGAN ==================== --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
        <h2 class="text-xl font-bold text-gray-800 flex items-center">
            <span class="w-2 h-8 bg-purple-600 rounded-full mr-3"></span>
            List Pelanggan Terdaftar
        </h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-600 uppercase text-xs font-bold tracking-wider">
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Informasi Profil</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4">Total Bayar</th>
                    <th class="px-6 py-4">Denda</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($pelanggans as $pelanggan)
                <tr class="hover:bg-purple-50/30 transition-colors duration-200 group">
                    <td class="px-6 py-4 font-bold text-gray-400">#{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                {{ substr($pelanggan->name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-gray-800">{{ $pelanggan->name }}</div>
                                <div class="text-[11px] text-gray-500 flex items-center gap-2">
                                    <span><i class="fas fa-envelope mr-1"></i> {{ $pelanggan->email }}</span>
                                    <span>|</span>
                                    <span><i class="fas fa-phone mr-1"></i> {{ $pelanggan->no_telp }}</span>
                                </div>
                                <div class="text-[11px] text-gray-400 mt-0.5"><i class="fas fa-location-dot mr-1"></i> {{ $pelanggan->alamat }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider
                            {{ $pelanggan->booking_aktif ? 'bg-amber-100 text-amber-700 border border-amber-200' : 'bg-green-100 text-green-700 border border-green-200' }}">
                            {{ $pelanggan->booking_aktif ? 'Sewa Aktif' : 'Selesai' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-700 text-sm">
                        Rp {{ number_format($pelanggan->total_bayar,0,',','.') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($pelanggan->denda > 0)
                            <span class="text-rose-600 font-bold text-sm">Rp {{ number_format($pelanggan->denda,0,',','.') }}</span>
                        @else
                            <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center">
                            <button class="p-2 bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-600 hover:text-white transition-all duration-300 shadow-sm" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection