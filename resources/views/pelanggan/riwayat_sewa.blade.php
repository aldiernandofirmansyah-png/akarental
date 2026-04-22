{{-- 
=================================================================
 FILE: pelanggan/riwayat_sewa.blade.php
 FUNGSI: Halaman untuk pelanggan melihat riwayat sewa sendiri
 FITUR: 
   - Tabel riwayat sewa pribadi
   - Status (Aktif/Selesai)
   - Tombol perpanjang untuk status Aktif
 DATA: Dikirim dari PelangganController (compact 'riwayatSaya')
=================================================================
--}}

@extends('layouts.app')

@section('title', 'Riwayat Sewa Saya')

@section('sidebar_menu')
<li><a href="/pelanggan/dashboard" onclick="showPelangganDashboard()" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition"><i class="fas fa-tachometer-alt mr-3"></i> Dashboard</a></li>
<li><a href="/pelanggan/riwayat-sewa" onclick="showPelangganRiwayat()" class="block px-4 py-3 rounded-lg sidebar-active"><i class="fas fa-history mr-3"></i> Riwayat Sewa</a></li>
@endsection

@section('content')

{{-- ==================== SAPAAN USER ==================== --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-history text-purple-600 mr-2"></i>Riwayat Sewa Saya
    </h1>
    <p class="text-purple-600 font-bold mt-1">
        <i class="fas fa-user-circle mr-1"></i> Selamat Datang, Pelanggan User
    </p>
</div>

{{-- ==================== TABEL RIWAYAT SEWA ==================== --}}
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">No</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Barang</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Tgl Mulai</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Tgl Kembali</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Total Biaya</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayatSaya as $item)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-medium text-sm">{{ $item->barang }}</td>
                    <td class="px-4 py-3 text-sm">{{ date('d/m/Y', strtotime($item->tanggal_mulai)) }}</td>
                    <td class="px-4 py-3 text-sm">{{ date('d/m/Y', strtotime($item->tanggal_kembali)) }}</td>
                    <td class="px-4 py-3 text-sm">Rp {{ number_format($item->total_biaya,0,',','.') }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs 
                            {{ $item->status == 'Aktif' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @if($item->status == 'Aktif')
                            <button onclick="showPerpanjangan({{ $item->id }})" class="text-blue-600 hover:text-blue-800 transition flex items-center gap-1">
                                <i class="fas fa-calendar-plus"></i> Perpanjang
                            </button>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function showPerpanjangan(id) {
    window.location.href = '/pelanggan/perpanjangan/' + id;
}
</script>
@endsection