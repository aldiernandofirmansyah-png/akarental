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
                        <div class="flex flex-col items-center gap-1">
                            <span class="px-2 py-1 rounded-lg text-[10px] font-black border {{ $payClass }}">
                                {{ strtoupper($item->status_pembayaran) }}
                            </span>
                            @if($item->status_pembayaran == 'DP Dibayar' && $item->waktu_bayar_dp)
                                <span class="text-[9px] text-gray-400">
                                    <i class="far fa-clock mr-1"></i>{{ $item->waktu_bayar_dp->format('d/m/y H:i') }}
                                </span>
                            @elseif($item->status_pembayaran == 'Lunas' && $item->waktu_bayar_lunas)
                                <span class="text-[9px] text-gray-400">
                                    <i class="far fa-clock mr-1"></i>{{ $item->waktu_bayar_lunas->format('d/m/y H:i') }}
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $item->status_sewa == 'Aktif' ? 'bg-amber-100 text-amber-700' : ($item->status_sewa == 'Selesai' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600') }}">
                            {{ $item->status_sewa }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex flex-col gap-2">
                            @if($item->status_pembayaran == 'Menunggu DP')
                                <button type="button" 
                                    onclick="openConfirmModal('{{ $item->id }}', '{{ $item->user->name }}', '{{ $item->user->email }}', '{{ $item->user->no_telp ?? '-' }}', '{{ $item->barang->nama_barang }}', '{{ route('admin.sewa.konfirmasi_dp', $item->id) }}')"
                                    class="w-full px-3 py-1 bg-blue-600 text-white text-[10px] font-bold rounded hover:bg-blue-700 transition">
                                    KONFIRMASI DP
                                </button>
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

{{-- ==================== MODAL KONFIRMASI ==================== --}}
<div id="confirmModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeConfirmModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-check-circle text-purple-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-xl leading-6 font-bold text-gray-900" id="modal-title">
                            Konfirmasi Booking
                        </h3>
                        <div class="mt-4 bg-gray-50 rounded-xl p-4 border border-gray-100 space-y-3">
                            <div class="flex justify-between border-b border-gray-200 pb-2">
                                <span class="text-xs font-bold text-gray-500 uppercase">Pelanggan</span>
                                <span id="modal-customer-name" class="text-sm font-bold text-gray-800">-</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-200 pb-2">
                                <span class="text-xs font-bold text-gray-500 uppercase">Email</span>
                                <span id="modal-customer-email" class="text-sm font-medium text-gray-600">-</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-200 pb-2">
                                <span class="text-xs font-bold text-gray-500 uppercase">No. HP</span>
                                <span id="modal-customer-phone" class="text-sm font-bold text-purple-600">-</span>
                            </div>
                            <div class="flex justify-between pt-1">
                                <span class="text-xs font-bold text-gray-500 uppercase">Barang Sewa</span>
                                <span id="modal-item-name" class="text-sm font-bold text-gray-800">-</span>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-gray-500 italic">
                            Pastikan data pelanggan di atas sudah sesuai sebelum mengonfirmasi pembayaran DP.
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                <form id="confirmForm" method="POST">
                    @csrf @method('PUT')
                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-2 bg-purple-600 text-base font-bold text-white hover:bg-purple-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-all">
                        YA, KONFIRMASI
                    </button>
                </form>
                <button type="button" onclick="closeConfirmModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-6 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                    BATAL
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openConfirmModal(id, name, email, phone, item, actionUrl) {
        document.getElementById('modal-customer-name').innerText = name;
        document.getElementById('modal-customer-email').innerText = email;
        document.getElementById('modal-customer-phone').innerText = phone;
        document.getElementById('modal-item-name').innerText = item;
        document.getElementById('confirmForm').action = actionUrl;
        
        const modal = document.getElementById('confirmModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeConfirmModal() {
        const modal = document.getElementById('confirmModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            closeConfirmModal();
        }
    });
</script>