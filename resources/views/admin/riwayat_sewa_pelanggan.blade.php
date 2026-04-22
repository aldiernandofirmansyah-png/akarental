{{-- 
=================================================================
 FILE: admin/riwayat_sewa_pelanggan.blade.php
 FUNGSI: Halaman untuk admin melihat semua riwayat sewa
 FITUR: 
   - Tabel riwayat sewa semua pelanggan
   - Status (Aktif/Selesai)
 DATA: Dikirim dari AdminController (compact 'riwayatSewa')
=================================================================
--}}

@extends('layouts.app')

@section('title', 'Riwayat Sewa')

@section('sidebar_menu')
<li><a href="/admin/dashboard" onclick="showAdminDashboard()" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition"><i class="fas fa-tachometer-alt mr-3"></i> Dashboard</a></li>
<li><a href="/admin/data-pelanggan" onclick="showDataPelanggan()" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition"><i class="fas fa-users mr-3"></i> Data Pelanggan</a></li>
<li><a href="/admin/riwayat-sewa" onclick="showRiwayatSewaAdmin()" class="block px-4 py-3 rounded-lg sidebar-active"><i class="fas fa-history mr-3"></i> Riwayat Sewa</a></li>
@endsection

@section('content')

{{-- ==================== SAPAAN USER ==================== --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-history text-purple-600 mr-2"></i>Riwayat Sewa
    </h1>
    <p class="text-purple-600 font-bold mt-1">
        <i class="fas fa-user-circle mr-1"></i> Selamat Datang, Admin User
    </p>
</div>

{{-- ==================== TABEL RIWAYAT SEWA ==================== --}}
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">No</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Pelanggan</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Barang</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Tgl Sewa</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Tgl Kembali</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Total</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayatSewa as $item)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-medium text-sm">{{ $item->pelanggan }}</td>
                    <td class="px-4 py-3 text-sm">{{ $item->barang }}</td>
                    <td class="px-4 py-3 text-sm">{{ date('d/m/Y', strtotime($item->tanggal_sewa)) }}</td>
                    <td class="px-4 py-3 text-sm">{{ date('d/m/Y', strtotime($item->tanggal_kembali)) }}</td>
                    <td class="px-4 py-3 text-sm">Rp {{ number_format($item->total,0,',','.') }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs 
                            {{ $item->status == 'Aktif' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection