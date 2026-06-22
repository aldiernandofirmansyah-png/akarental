@extends('layouts.app')

@section('title', 'Konfirmasi Booking | AKA Rental')

@section('content')

{{-- ==================== HEADER SECTION ==================== --}}
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">
            Konfirmasi <span class="text-purple-600">Booking</span>
        </h1>
        <p class="text-gray-500 mt-1 font-medium">
            Kelola transaksi dari DP hingga proses sewa berlangsung.
        </p>
    </div>
</div>

{{-- ==================== TABEL BOOKING ==================== --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-600 uppercase text-xs font-bold tracking-wider">
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4">Barang</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($bookings as $item)
                <tr class="hover:bg-purple-50/30 transition-colors duration-200">
                    <td class="px-6 py-4 font-bold text-gray-400">#{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-800">{{ $item->user->name }}</div>
                        <div class="text-[10px] text-gray-500">{{ $item->user->email }} | {{ $item->user->no_telp ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-800">{{ $item->barang->nama_barang }}</div>
                        @if($item->kode_barang_fisik)
                            <div class="text-[10px] text-purple-600 font-bold">Kode: {{ $item->kode_barang_fisik }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-xs space-y-1">
                            <div class="flex justify-between font-bold text-gray-800"><span>Total:</span> <span>Rp{{ number_format($item->total_biaya,0,',','.') }}</span></div>
                            <div class="flex justify-between text-yellow-600"><span>DP:</span> <span>Rp{{ number_format($item->dp_amount,0,',','.') }}</span></div>
                            <div class="flex justify-between text-purple-600 border-t pt-1"><span>Sisa:</span> <span>Rp{{ number_format($item->sisa_bayar,0,',','.') }}</span></div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 rounded-lg text-[10px] font-black border {{ $item->status_pembayaran == 'DP Dibayar' ? 'bg-blue-100 text-blue-700 border-blue-200' : 'bg-rose-100 text-rose-700 border-rose-200' }}">
                            {{ strtoupper($item->status_pembayaran) }}
                        </span>
                        <div class="text-[10px] text-gray-500 mt-1">{{ $item->status_sewa }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex flex-col gap-2">
                            @if($item->status_pembayaran == 'Menunggu DP')
                                <button type="button" 
                                    onclick="openConfirmModal('{{ $item->id }}', '{{ $item->user->name }}', '{{ $item->user->email }}', '{{ $item->user->no_telp ?? '-' }}', '{{ $item->barang->nama_barang }}', '{{ $item->tanggal_mulai->format('d M Y') }}', '{{ $item->tanggal_kembali->format('d M Y') }}', '{{ route('admin.sewa.konfirmasi_dp', $item->id) }}')"
                                    class="w-full px-3 py-1 bg-blue-600 text-white text-[10px] font-bold rounded hover:bg-blue-700 transition">
                                    KONFIRMASI DP
                                </button>
                            @endif

                            @if($item->status_sewa == 'Booking' && $item->status_pembayaran == 'DP Dibayar')
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
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL KONFIRMASI --}}
<div id="confirmModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeConfirmModal()"></div>

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 relative">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Konfirmasi Booking & Kode Barang</h3>
            <form id="confirmForm" method="POST">
                @csrf @method('PUT')
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 space-y-3 mb-4">
                    <p class="text-sm">Pelanggan: <span id="modal-name" class="font-bold"></span></p>
                    <p class="text-sm">Email: <span id="modal-email" class="font-bold"></span></p>
                    <p class="text-sm">No. HP: <span id="modal-phone" class="font-bold"></span></p>
                    <p class="text-sm">Barang: <span id="modal-item" class="font-bold"></span></p>
                    <p class="text-sm">Masa Sewa: <span id="modal-masa" class="font-bold"></span></p>
                    
                    <div class="mt-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kode Barang Fisik</label>
                        <input type="text" name="kode_barang_fisik" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeConfirmModal()" class="px-4 py-2 bg-gray-200 rounded-lg text-sm font-bold">BATAL</button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-bold">KONFIRMASI</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openConfirmModal(id, name, email, phone, item, mulai, kembali, actionUrl) {
        document.getElementById('modal-name').innerText = name;
        document.getElementById('modal-email').innerText = email;
        document.getElementById('modal-phone').innerText = phone;
        document.getElementById('modal-item').innerText = item;
        document.getElementById('modal-masa').innerText = mulai + ' s/d ' + kembali;
        document.getElementById('confirmForm').action = actionUrl;
        document.getElementById('confirmModal').classList.remove('hidden');
    }
    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }
</script>
@endsection