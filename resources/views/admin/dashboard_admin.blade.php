{{-- 
=================================================================
 FILE: admin/dashboard_admin.blade.php
 FUNGSI: Halaman dashboard untuk ADMIN
 FITUR: 
   - Statistik card (total barang, kategori kamera, camping, paket, total pelanggan, pendapatan)
   - Tabel daftar barang dengan tombol edit/hapus
   - Modal tambah barang
   - Modal edit barang
 DATA: Dikirim dari AdminController (dengan compact)
=================================================================
--}}

@extends('layouts.app')

@section('title', 'Dashboard Admin | AKA Rental')

@section('sidebar_menu')
<li><a href="/admin/dashboard" class="block px-4 py-3 rounded-lg sidebar-active"><i class="fas fa-tachometer-alt mr-3"></i> Dashboard</a></li>
<li><a href="/admin/data-pelanggan" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition text-gray-700 font-medium"><i class="fas fa-users mr-3"></i> Data Pelanggan</a></li>
<li><a href="/admin/riwayat-sewa" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition text-gray-700 font-medium"><i class="fas fa-history mr-3"></i> Riwayat Sewa</a></li>
@endsection

@section('content')

{{-- ==================== HEADER SECTION ==================== --}}
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">
            Dashboard <span class="text-purple-600">Admin</span>
        </h1>
        <p class="text-gray-500 mt-1 font-medium">
            <i class="fas fa-hand-sparkles text-yellow-500 mr-1"></i> Halo, Selamat Datang Kembali {{ auth()->user()->name }}!
        </p>
    </div>
    <div class="flex items-center gap-3">
        <button onclick="openModal('tambahBarangModal')" class="bg-purple-600 text-white px-5 py-2.5 rounded-xl hover:bg-purple-700 transition-all duration-300 shadow-md hover:shadow-lg flex items-center font-semibold">
            <i class="fas fa-plus-circle mr-2 text-lg"></i> Tambah Barang
        </button>
    </div>
</div>

{{-- ==================== STATS CARDS ==================== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
    {{-- Card Total Barang --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-box text-blue-600 text-xl"></i>
            </div>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Total Barang</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalBarang }}</h3>
        </div>
    </div>
    
    {{-- Card Kategori Kamera --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-cyan-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-camera text-cyan-600 text-xl"></i>
            </div>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Kamera</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalKamera }}</h3>
        </div>
    </div>
    
    {{-- Card Kategori Camping --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-campground text-green-600 text-xl"></i>
            </div>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Camping</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalCamping }}</h3>
        </div>
    </div>
    
    {{-- Card Kategori Paket --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-gift text-purple-600 text-xl"></i>
            </div>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Paket</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalPaket }}</h3>
        </div>
    </div>
    
    {{-- Card Total Pelanggan --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-yellow-600 text-xl"></i>
            </div>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Pelanggan</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalPelanggan }}</h3>
        </div>
    </div>

    {{-- Card Total Pendapatan --}}
    <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-5 shadow-lg text-white card-hover xl:col-span-1">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-md">
                <i class="fas fa-wallet text-white text-xl"></i>
            </div>
        </div>
        <div>
            <p class="text-white/80 text-sm font-semibold uppercase tracking-wider">Pendapatan</p>
            <h3 class="text-xl font-bold mt-1">Rp {{ number_format($totalPendapatan,0,',','.') }}</h3>
        </div>
    </div>
</div>

{{-- ==================== MAIN DATA TABLE ==================== --}}
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gray-50/30">
        <h2 class="text-xl font-bold text-gray-800 flex items-center">
            <span class="w-2 h-8 bg-purple-600 rounded-full mr-3"></span>
            Daftar Barang Tersedia
        </h2>
        <div class="relative w-full sm:w-64">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <i class="fas fa-search text-gray-400"></i>
            </span>
            <input type="text" id="searchBarang" onkeyup="filterBarang()" class="pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all text-sm w-full" placeholder="Cari barang...">
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="barangTable">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 uppercase text-[10px] font-bold tracking-widest border-b border-gray-100">
                    <th class="px-6 py-4">ID</th>
                    <th class="px-6 py-4">Info Barang</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4 text-center">Harga Sewa</th>
                    <th class="px-6 py-4 text-center">Stok</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($barangs as $barang)
                <tr class="hover:bg-gray-50/50 transition-colors duration-200 group">
                    <td class="px-6 py-4 font-bold text-gray-300 text-xs">#{{ str_pad($barang->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center min-w-[200px]">
                            <div class="h-12 w-12 flex-shrink-0 rounded-xl overflow-hidden shadow-sm border-2 border-white group-hover:border-purple-200 transition-all">
                                @if(!empty($barang->foto) && file_exists(public_path($barang->foto)))
                                    <img src="{{ asset($barang->foto) }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-300"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-gray-800">{{ $barang->nama_barang }}</div>
                                <div class="text-[11px] text-gray-400 mt-0.5 line-clamp-1">{{ $barang->deskripsi }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $catClass = match($barang->kategori) {
                                'Kamera' => 'bg-blue-50 text-blue-600 border-blue-100',
                                'Alat Camping' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                default => 'bg-purple-50 text-purple-600 border-purple-100'
                            };
                            $catIcon = match($barang->kategori) {
                                'Kamera' => 'fas fa-camera',
                                'Alat Camping' => 'fas fa-campground',
                                default => 'fas fa-gift'
                            };
                        @endphp
                        <span class="px-3 py-1.5 rounded-lg text-[10px] font-black border {{ $catClass }} flex items-center w-fit uppercase tracking-wider">
                            <i class="{{ $catIcon }} mr-1.5"></i> {{ $barang->kategori }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="text-sm font-bold text-gray-700">Rp{{ number_format($barang->harga_sewa,0,',','.') }}</div>
                        <div class="text-[10px] text-gray-400 font-medium italic">per hari</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex flex-col items-center">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-black {{ $barang->stok > 0 ? 'bg-green-50 text-green-600' : 'bg-rose-50 text-rose-600' }}">
                                {{ $barang->stok }} UNIT
                            </span>
                            @if($barang->stok <= 2 && $barang->stok > 0)
                                <span class="text-[9px] text-orange-500 font-bold mt-1 animate-pulse uppercase">Limit!</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center items-center gap-2">
                            <button onclick="editBarang({{ $barang->id }}, '{{ $barang->nama_barang }}', '{{ $barang->kategori }}', '{{ $barang->deskripsi }}', {{ $barang->harga_sewa }}, {{ $barang->stok }})" class="p-2 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-500 hover:text-white transition-all duration-300 shadow-sm border border-amber-100" title="Edit">
                                <i class="fas fa-pen-to-square text-xs"></i>
                            </button>
                            <button onclick="hapusBarang({{ $barang->id }})" class="p-2 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all duration-300 shadow-sm border border-rose-100" title="Hapus">
                                <i class="fas fa-trash-can text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ==================== MODALS ==================== --}}
{{-- MODAL TAMBAH BARANG --}}
<div id="tambahBarangModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4 transition-all duration-300">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all animate-in fade-in zoom-in duration-300">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-plus-circle mr-3"></i> Tambah Koleksi Baru
            </h2>
            <button onclick="closeModal('tambahBarangModal')" class="text-white/80 hover:text-white transition-colors text-2xl font-bold">&times;</button>
        </div>
        
        <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto custom-scrollbar">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Barang</label>
                        <input type="text" name="nama_barang" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition-all" placeholder="Contoh: Sony A7III Mirrorless" required>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Foto Barang</label>
                        <div class="relative group">
                            <input type="file" name="foto" id="fotoInput" class="hidden" accept="image/*" onchange="updateFileName(this)">
                            <label for="fotoInput" class="w-full flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-2xl py-6 hover:bg-gray-50 hover:border-purple-400 cursor-pointer transition-all">
                                <i class="fas fa-cloud-arrow-up text-3xl text-gray-400 group-hover:text-purple-500 transition-colors"></i>
                                <span class="mt-2 text-sm text-gray-500 group-hover:text-purple-600" id="fileNameDisplay">Klik untuk upload foto</span>
                                <span class="text-xs text-gray-400 mt-1">PNG, JPG up to 2MB</span>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Kategori</label>
                        <select name="kategori" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition-all" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Kamera">📷 Kamera</option>
                            <option value="Alat Camping">⛺ Alat Camping</option>
                            <option value="Paket">📦 Paket</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Stok Unit</label>
                        <input type="number" name="stok" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition-all" placeholder="0" required>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Harga Sewa / Hari</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 font-bold">Rp</span>
                            <input type="number" name="harga_sewa" class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition-all" placeholder="0" required>
                        </div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Deskripsi Produk</label>
                        <textarea name="deskripsi" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition-all resize-none" placeholder="Jelaskan spesifikasi dan kelengkapan barang..."></textarea>
                    </div>
                </div>
            </div>
            
            <div class="p-6 bg-gray-50 flex gap-3">
                <button type="button" onclick="closeModal('tambahBarangModal')" class="flex-1 bg-white border border-gray-300 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-100 transition-all">Batal</button>
                <button type="submit" class="flex-1 bg-purple-600 text-white py-3 rounded-xl font-bold hover:bg-purple-700 shadow-lg shadow-purple-200 transition-all">Simpan Barang</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT BARANG (Sama strukturnya dengan tambah, tapi dengan ID yang berbeda untuk JS) --}}
<div id="editBarangModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4 transition-all duration-300">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all animate-in fade-in zoom-in duration-300">
        <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-pen-to-square mr-3"></i> Edit Informasi Barang
            </h2>
            <button onclick="closeModal('editBarangModal')" class="text-white/80 hover:text-white transition-colors text-2xl font-bold">&times;</button>
        </div>
        
        <form id="editBarangForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto custom-scrollbar">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Barang</label>
                        <input type="text" name="nama_barang" id="editNamaBarang" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all" required>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Ganti Foto (Opsional)</label>
                        <input type="file" name="foto" class="w-full border rounded-xl px-4 py-2 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Kategori</label>
                        <select name="kategori" id="editKategori" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all" required>
                            <option value="Kamera">📷 Kamera</option>
                            <option value="Alat Camping">⛺ Alat Camping</option>
                            <option value="Paket">📦 Paket</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Stok Unit</label>
                        <input type="number" name="stok" id="editStok" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all" required>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Harga Sewa / Hari</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 font-bold">Rp</span>
                            <input type="number" name="harga_sewa" id="editHarga" class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all" required>
                        </div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Deskripsi Produk</label>
                        <textarea name="deskripsi" id="editDeskripsi" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all resize-none"></textarea>
                    </div>
                </div>
            </div>
            
            <div class="p-6 bg-gray-50 flex gap-3">
                <button type="button" onclick="closeModal('editBarangModal')" class="flex-1 bg-white border border-gray-300 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-100 transition-all">Batal</button>
                <button type="submit" class="flex-1 bg-amber-600 text-white py-3 rounded-xl font-bold hover:bg-amber-700 shadow-lg shadow-amber-200 transition-all">Update Data</button>
            </div>
        </form>
    </div>
</div>

{{-- Hidden Form untuk Hapus --}}
<form id="deleteBarangForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

{{-- TOAST NOTIFICATION --}}
<div id="toast" class="fixed bottom-10 right-10 z-[100] transform translate-y-20 opacity-0 transition-all duration-500">
    <div class="bg-gray-800 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center border-l-4 border-green-500">
        <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
        <div>
            <p class="font-bold text-sm" id="toastTitle">Berhasil!</p>
            <p class="text-xs text-gray-400" id="toastMessage">Operasi telah diselesaikan.</p>
        </div>
    </div>
</div>

{{-- ==================== SCRIPTS ==================== --}}
<script>
    function updateFileName(input) {
        const display = document.getElementById('fileNameDisplay');
        if (input.files && input.files.length > 0) {
            display.innerText = input.files[0].name;
            display.classList.add('text-purple-600', 'font-bold');
        } else {
            display.innerText = 'Klik untuk upload foto';
            display.classList.remove('text-purple-600', 'font-bold');
        }
    }

    // Search Function
    function filterBarang() {
        const input = document.getElementById('searchBarang');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('barangTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            let found = false;
            const td = tr[i].getElementsByTagName('td');
            for (let j = 0; j < td.length; j++) {
                if (td[j].textContent.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
            tr[i].style.display = found ? "" : "none";
        }
    }

    // Modal Control
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    // Edit Function
    function editBarang(id, nama, kategori, deskripsi, harga, stok) {
        // Set data ke input modal
        document.getElementById('editNamaBarang').value = nama;
        document.getElementById('editKategori').value = kategori;
        document.getElementById('editDeskripsi').value = deskripsi;
        document.getElementById('editHarga').value = harga;
        document.getElementById('editStok').value = stok;
        
        // Set action URL form secara dinamis
        let url = "{{ route('admin.barang.update', ':id') }}";
        url = url.replace(':id', id);
        document.getElementById('editBarangForm').action = url;
        
        openModal('editBarangModal');
    }

    // Delete Function
    function hapusBarang(id) {
        if(confirm('Apakah Anda yakin ingin menghapus barang ini secara permanen?')) {
            const form = document.getElementById('deleteBarangForm');
            let url = "{{ route('admin.barang.delete', ':id') }}";
            url = url.replace(':id', id);
            form.action = url;
            form.submit();
        }
    }

    // Form Submit Simulation
    function handleFormSubmit(event, action) {
        event.preventDefault();
        const modalId = action === 'Tambah' ? 'tambahBarangModal' : 'editBarangModal';
        closeModal(modalId);
        showToast('Berhasil!', `Data barang telah berhasil di${action === 'Tambah' ? 'tambahkan' : 'update'}.`);
    }

    // Toast Function
    function showToast(title, message, bg = 'bg-gray-800', border = 'border-green-500') {
        const toast = document.getElementById('toast');
        const toastTitle = document.getElementById('toastTitle');
        const toastMessage = document.getElementById('toastMessage');
        
        toastTitle.innerText = title;
        toastMessage.innerText = message;
        
        // Reset and apply classes
        toast.children[0].className = `text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center border-l-4 ${bg} ${border}`;
        
        toast.classList.remove('translate-y-20', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
        
        setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0');
            toast.classList.remove('translate-y-0', 'opacity-100');
        }, 3000);
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>
@endsection