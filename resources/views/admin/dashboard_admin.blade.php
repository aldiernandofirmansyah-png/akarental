@extends('layouts.app')

@section('title', 'Dashboard Admin | AKA Rental')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-gray-800">Dashboard Admin 📊</h1>
    <p class="text-gray-500">Ringkasan aktivitas penyewaan terkini.</p>
</div>

{{-- Statistik Utama --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 card-hover">
        <div class="text-gray-400 mb-2"><i class="fas fa-box text-2xl"></i></div>
        <p class="text-sm font-bold text-gray-500 uppercase">Total Barang / Stok</p>
        <p class="text-3xl font-black text-gray-800">{{ $totalBarang }} <span class="text-lg text-gray-400 font-medium">/ {{ $barangs->sum('stok') }}</span></p>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 card-hover">
        <div class="text-gray-400 mb-2"><i class="fas fa-users text-2xl"></i></div>
        <p class="text-sm font-bold text-gray-500 uppercase">Pelanggan Aktif</p>
        <p class="text-3xl font-black text-gray-800">{{ $totalPelanggan }}</p>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 card-hover">
        <div class="text-gray-400 mb-2"><i class="fas fa-wallet text-2xl"></i></div>
        <p class="text-sm font-bold text-gray-500 uppercase">Total Pendapatan</p>
        <p class="text-xl font-black text-emerald-600">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>
</div>

{{-- Statistik Kategori --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 rounded-2xl text-white">
        <p class="text-sm font-bold opacity-80 uppercase">Kamera 📷</p>
        <p class="text-xl font-black">{{ $totalKamera }} Barang</p>
        <p class="text-xs font-medium mt-1">Stok: {{ $barangs->where('kategori', 'Kamera')->sum('stok') }}</p>
    </div>
    <div class="bg-gradient-to-br from-amber-500 to-amber-600 p-6 rounded-2xl text-white">
        <p class="text-sm font-bold opacity-80 uppercase">Alat Camping ⛺</p>
        <p class="text-xl font-black">{{ $totalCamping }} Barang</p>
        <p class="text-xs font-medium mt-1">Stok: {{ $barangs->where('kategori', 'Alat Camping')->sum('stok') }}</p>
    </div>
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-6 rounded-2xl text-white">
        <p class="text-sm font-bold opacity-80 uppercase">Paket 📦</p>
        <p class="text-xl font-black">{{ $totalPaket }} Barang</p>
        <p class="text-xs font-medium mt-1">Stok: {{ $barangs->where('kategori', 'Paket')->sum('stok') }}</p>
    </div>
</div>

{{-- Sewa Aktif --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
        <h2 class="text-lg font-bold text-gray-800">Sewa Sedang Aktif ⏳</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-xs uppercase">
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4">Barang (Kode)</th>
                    <th class="px-6 py-4 text-center">Masa Sewa</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($sewaAktif as $item)
                <tr class="hover:bg-purple-50/20 transition-colors">
                    <td class="px-6 py-4 text-sm font-bold text-gray-800">👤 {{ $item->user->name }}</td>
                    <td class="px-6 py-4 text-sm">{{ $item->barang->nama_barang }} <span class="font-bold text-purple-600">({{ $item->kode_barang_fisik }})</span></td>
                    <td class="px-6 py-4 text-sm font-bold text-center text-gray-600">
                        {{ $item->tanggal_mulai->format('d M') }} - {{ $item->tanggal_kembali->format('d M Y') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
