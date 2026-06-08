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

@section('title', 'Riwayat Sewa | AKA Rental')

@section('sidebar_menu')
<li><a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition text-gray-700 font-medium"><i class="fas fa-tachometer-alt mr-3"></i> Dashboard</a></li>
<li><a href="{{ route('admin.data_pelanggan') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition text-gray-700 font-medium"><i class="fas fa-users mr-3"></i> Data Pelanggan</a></li>
<li><a href="{{ route('admin.riwayat_sewa') }}" class="block px-4 py-3 rounded-lg sidebar-active"><i class="fas fa-history mr-3"></i> Riwayat Sewa</a></li>
@endsection

@section('content')

{{-- ==================== HEADER SECTION ==================== --}}
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">
            Riwayat <span class="text-purple-600">Sewa</span>
        </h1>
        <p class="text-gray-500 mt-1 font-medium">
            Pantau seluruh aktivitas penyewaan barang di AKA Rental.
        </p>
    </div>
</div>

{{-- ==================== TABEL RIWAYAT SEWA ==================== --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
        <h2 class="text-xl font-bold text-gray-800 flex items-center">
            <span class="w-2 h-8 bg-purple-600 rounded-full mr-3"></span>
            Log Aktivitas Sewa
        </h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-600 uppercase text-xs font-bold tracking-wider">
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4">Barang</th>
                    <th class="px-6 py-4 text-center">Rincian Biaya</th>
                    <th class="px-6 py-4 text-center">Pembayaran</th>
                    <th class="px-6 py-4 text-center">Status Sewa</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($riwayatSewa as $item)
                <tr class="hover:bg-purple-50/30 transition-colors duration-200 group">
                    <td class="px-6 py-4 font-bold text-gray-400">#{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-800">{{ $item->user->name }}</div>
                        <div class="text-[10px] text-gray-500">{{ date('d M Y', strtotime($item->tanggal_mulai)) }} - {{ date('d M Y', strtotime($item->tanggal_kembali)) }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-[10px] font-bold">{{ $item->barang->nama_barang }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-[11px] space-y-1">
                            <div class="flex justify-between"><span>Total:</span> <span class="font-bold">Rp{{ number_format($item->total_biaya,0,',','.') }}</span></div>
                            <div class="flex justify-between text-yellow-600"><span>DP:</span> <span class="font-bold">Rp{{ number_format($item->dp_amount,0,',','.') }}</span></div>
                            <div class="flex justify-between text-purple-600 border-t pt-1"><span>Sisa:</span> <span class="font-bold">Rp{{ number_format($item->sisa_bayar,0,',','.') }}</span></div>
                            @if($item->denda > 0)
                                <div class="flex justify-between text-rose-600 font-bold bg-rose-50 px-1 rounded">
                                    <span>Denda:</span>
                                    <span>+Rp{{ number_format($item->denda,0,',','.') }}</span>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @php
                            $payClass = match($item->status_pembayaran) {
                                'Lunas' => 'bg-green-100 text-green-700 border-green-200',
                                'DP Dibayar' => 'bg-blue-100 text-blue-700 border-blue-200',
                                default => 'bg-rose-100 text-rose-700 border-rose-200'
                            };
                        @endphp
                        <span class="px-2 py-1 rounded-lg text-[10px] font-black border {{ $payClass }}">
                            {{ strtoupper($item->status_pembayaran) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $item->status_sewa == 'Aktif' ? 'bg-amber-100 text-amber-700' : ($item->status_sewa == 'Selesai' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600') }}">
                            {{ $item->status_sewa }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex flex-col gap-2">
                            @if($item->status_pembayaran == 'Menunggu DP')
                                <form action="{{ route('admin.sewa.konfirmasi_dp', $item->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button type="submit" class="w-full px-3 py-1 bg-blue-600 text-white text-[10px] font-bold rounded hover:bg-blue-700 transition">
                                        KONFIRMASI DP
                                    </button>
                                </form>
                            @endif

                            @if($item->status_sewa == 'Booking' && $item->status_pembayaran != 'Menunggu DP')
                                <form action="{{ route('admin.sewa.mulai', $item->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button type="submit" class="w-full px-3 py-1 bg-amber-500 text-white text-[10px] font-bold rounded hover:bg-amber-600 transition">
                                        MULAI SEWA
                                    </button>
                                </form>
                            @endif

                            @if($item->status_sewa == 'Aktif')
                                <form action="{{ route('admin.sewa.selesai', $item->id) }}" method="POST" onsubmit="return confirm('Selesaikan sewa ini?')">
                                    @csrf @method('PUT')
                                    <button type="submit" class="w-full px-3 py-1 bg-green-600 text-white text-[10px] font-bold rounded hover:bg-green-700 transition">
                                        SELESAI SEWA
                                    </button>
                                </form>
                            @endif

                            @if($item->status_sewa == 'Selesai')
                                <span class="text-[10px] text-gray-400 font-bold italic">No Action</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection