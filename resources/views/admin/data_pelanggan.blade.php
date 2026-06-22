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
<div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
    <div>
        <h1 class="text-3xl font-black text-gray-800 tracking-tight">
            Data <span class="text-purple-600">Pelanggan</span>
        </h1>
        <p class="text-gray-500 mt-2 font-medium flex items-center">
            <span class="w-5 h-5 bg-purple-100 text-purple-600 rounded-md flex items-center justify-center mr-2 text-[10px]">
                <i class="fas fa-users"></i>
            </span>
            Kelola dan pantau informasi pelanggan setia AKA Rental.
        </p>
    </div>
</div>

{{-- ==================== TABEL DATA PELANGGAN ==================== --}}
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-8 py-6 border-b border-gray-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gray-50/30">
        <h2 class="text-xl font-bold text-gray-800 flex items-center">
            <span class="w-2 h-8 bg-purple-600 rounded-full mr-4"></span>
            List Pelanggan Terdaftar
        </h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 uppercase text-[10px] font-black tracking-widest border-b border-gray-100">
                    <th class="px-8 py-5">No</th>
                    <th class="px-8 py-5">Informasi Profil</th>
                    <th class="px-8 py-5 text-center">Status</th>
                    <th class="px-8 py-5 text-right">Total Bayar</th>
                    <th class="px-8 py-5 text-right">Denda</th>
                    <th class="px-8 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($pelanggans as $pelanggan)
                <tr class="hover:bg-gray-50/30 transition-colors duration-200 group">
                    <td class="px-8 py-6 font-bold text-gray-300 text-xs">#{{ $loop->iteration }}</td>
                    <td class="px-8 py-6">
                        <div class="flex items-center min-w-[250px]">
                            <div class="h-12 w-12 flex-shrink-0 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-md group-hover:scale-110 transition-transform">
                                {{ substr($pelanggan->name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-black text-gray-800">{{ $pelanggan->name }}</div>
                                <div class="text-[11px] text-gray-400 mt-1 flex flex-wrap gap-x-3 gap-y-1">
                                    <span class="flex items-center"><i class="fas fa-envelope mr-1.5 text-purple-400"></i> {{ $pelanggan->email }}</span>
                                    <span class="flex items-center"><i class="fas fa-phone mr-1.5 text-green-400"></i> {{ $pelanggan->no_telp }}</span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border
                            {{ $pelanggan->booking_aktif ? 'bg-amber-50 text-amber-600 border-amber-100' : 'bg-emerald-50 text-emerald-600 border-emerald-100' }}">
                            {{ $pelanggan->booking_aktif ? 'Sewa Aktif' : 'Selesai' }}
                        </span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <span class="text-sm font-black text-gray-700">Rp{{ number_format($pelanggan->total_bayar,0,',','.') }}</span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        @if($pelanggan->denda > 0)
                            <span class="px-3 py-1 bg-rose-50 text-rose-600 rounded-lg font-black text-xs border border-rose-100 italic">
                                +Rp{{ number_format($pelanggan->denda,0,',','.') }}
                            </span>
                        @else
                            <span class="text-gray-300 text-xs font-bold italic">- Nihil -</span>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-center">
                            <button class="p-2.5 bg-white text-purple-600 rounded-xl hover:bg-purple-600 hover:text-white transition-all duration-300 shadow-sm border border-gray-100" title="Lihat Detail">
                                <i class="fas fa-eye text-sm"></i>
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