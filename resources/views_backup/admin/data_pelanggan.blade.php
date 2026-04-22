@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('sidebar_menu')
<li><a href="/admin/dashboard" onclick="showAdminDashboard()" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition"><i class="fas fa-tachometer-alt mr-3"></i> Dashboard</a></li>
<li><a href="/admin/data-pelanggan" onclick="showDataPelanggan()" class="block px-4 py-3 rounded-lg sidebar-active"><i class="fas fa-users mr-3"></i> Data Pelanggan</a></li>
<li><a href="/admin/riwayat-sewa" onclick="showRiwayatSewaAdmin()" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition"><i class="fas fa-history mr-3"></i> Riwayat Sewa</a></li>
@endsection

@section('content')

<?php
$pelanggans = [
    (object) ['id' => 1, 'name' => 'Neymar Junior', 'email' => 'neymar@email.com', 'no_telp' => '081234567890', 'alamat' => 'Jl. Brasil No. 10', 'booking_aktif' => true, 'total_bayar' => 450000, 'denda' => 0],
    (object) ['id' => 2, 'name' => 'Lionel Messi', 'email' => 'messi@email.com', 'no_telp' => '081234567891', 'alamat' => 'Jl. Argentina No. 5', 'booking_aktif' => true, 'total_bayar' => 300000, 'denda' => 25000],
    (object) ['id' => 3, 'name' => 'Mesut Ozil', 'email' => 'ozil@email.com', 'no_telp' => '081234567892', 'alamat' => 'Jl. Jerman No. 15', 'booking_aktif' => false, 'total_bayar' => 600000, 'denda' => 0],
];
?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-users text-purple-600 mr-2"></i>Data Pelanggan
    </h1>
    <p class="text-purple-600 font-bold mt-1">
        <i class="fas fa-user-circle mr-1"></i> Selamat Datang, Admin User
    </p>
</div>

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">No</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Nama</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Email</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">No. Telepon</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Alamat</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Total Bayar</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelanggans as $pelanggan)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-medium text-sm">{{ $pelanggan->name }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $pelanggan->email }}</td>
                    <td class="px-4 py-3 text-sm">{{ $pelanggan->no_telp }}</td>
                    <td class="px-4 py-3 text-sm">{{ $pelanggan->alamat }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs 
                            {{ $pelanggan->booking_aktif ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                            {{ $pelanggan->booking_aktif ? 'Aktif' : 'Selesai' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm">Rp {{ number_format($pelanggan->total_bayar,0,',','.') }}</td>
                    <td class="px-4 py-3 text-sm {{ $pelanggan->denda > 0 ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                        Rp {{ number_format($pelanggan->denda,0,',','.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection