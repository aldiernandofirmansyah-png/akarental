{{-- 
=================================================================
 FILE: admin/dashboard_admin.blade.php
 FUNGSI: Halaman dashboard untuk ADMIN
 FITUR: 
   - Statistik card (total barang, kategori kamera, camping, paket, total pelanggan)
   - Tabel daftar barang dengan tombol edit/hapus
   - Modal tambah barang
   - Modal edit barang
 DATA: Dikirim dari AdminController (dengan compact)
=================================================================
--}}

@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('sidebar_menu')
<li><a href="/admin/dashboard" onclick="showAdminDashboard()" class="block px-4 py-3 rounded-lg sidebar-active"><i class="fas fa-tachometer-alt mr-3"></i> Dashboard</a></li>
<li><a href="/admin/data-pelanggan" onclick="showDataPelanggan()" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition"><i class="fas fa-users mr-3"></i> Data Pelanggan</a></li>
<li><a href="/admin/riwayat-sewa" onclick="showRiwayatSewaAdmin()" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition"><i class="fas fa-history mr-3"></i> Riwayat Sewa</a></li>
@endsection

@section('content')

{{-- ==================== SAPAAN USER ==================== --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-tachometer-alt text-purple-600 mr-2"></i>Dashboard Admin
    </h1>
    <p class="text-purple-600 font-bold mt-1">
        <i class="fas fa-user-circle mr-1"></i> Selamat Datang, Admin Kuuuuu
    </p>
</div>

{{-- ==================== TOMBOL TAMBAH BARANG ==================== --}}
<div class="flex justify-end mb-6">
    <button onclick="openModal('tambahBarangModal')" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
        <i class="fas fa-plus mr-2"></i>Tambah Barang
    </button>
</div>

{{-- ==================== CARD STATISTIK (5 CARD) ==================== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    {{-- Card Total Barang --}}
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-4 text-white shadow-lg">
        <div class="flex justify-between">
            <div>
                <p class="text-sm opacity-90">Total Barang</p>
                <p class="text-3xl font-bold">{{ $totalBarang }}</p>
            </div>
            <i class="fas fa-box text-3xl opacity-50"></i>
        </div>
    </div>
    
    {{-- Card Kategori Kamera --}}
    <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 rounded-xl p-4 text-white shadow-lg">
        <div class="flex justify-between">
            <div>
                <p class="text-sm opacity-90">Kategori Kamera</p>
                <p class="text-3xl font-bold">{{ $totalKamera }}</p>
            </div>
            <i class="fas fa-camera text-3xl opacity-50"></i>
        </div>
    </div>
    
    {{-- Card Kategori Camping --}}
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-4 text-white shadow-lg">
        <div class="flex justify-between">
            <div>
                <p class="text-sm opacity-90">Kategori Camping</p>
                <p class="text-3xl font-bold">{{ $totalCamping }}</p>
            </div>
            <i class="fas fa-campground text-3xl opacity-50"></i>
        </div>
    </div>
    
    {{-- Card Kategori Paket --}}
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-4 text-white shadow-lg">
        <div class="flex justify-between">
            <div>
                <p class="text-sm opacity-90">Kategori Paket</p>
                <p class="text-3xl font-bold">{{ $totalPaket }}</p>
            </div>
            <i class="fas fa-gift text-3xl opacity-50"></i>
        </div>
    </div>
    
    {{-- Card Total Pelanggan --}}
    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl p-4 text-white shadow-lg">
        <div class="flex justify-between">
            <div>
                <p class="text-sm opacity-90">Total Pelanggan</p>
                <p class="text-3xl font-bold">{{ $totalPelanggan }}</p>
            </div>
            <i class="fas fa-users text-3xl opacity-50"></i>
        </div>
    </div>
</div>

{{-- ==================== TABEL DAFTAR BARANG ==================== --}}
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="p-4 border-b bg-gray-50">
        <h2 class="text-lg font-bold"><i class="fas fa-list text-purple-600 mr-2"></i>Daftar Barang</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Foto</th>
                    <th class="px-4 py-3 text-left">Nama Barang</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Harga/Hari</th>
                    <th class="px-4 py-3 text-left">Stok</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangs as $barang)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">
                        @php
                            $fotoPath = public_path($barang->foto);
                            $fotoExists = !empty($barang->foto) && file_exists($fotoPath);
                        @endphp
                        
                        @if($fotoExists)
                            <img src="{{ asset($barang->foto) }}" alt="{{ $barang->nama_barang }}" class="w-10 h-10 object-cover rounded-lg">
                        @else
                            <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-camera text-gray-400"></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-4 py-3 font-medium">{{ $barang->nama_barang }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs 
                            {{ $barang->kategori == 'Kamera' ? 'bg-blue-100 text-blue-700' : ($barang->kategori == 'Alat Camping' ? 'bg-green-100 text-green-700' : 'bg-purple-100 text-purple-700') }}">
                            {{ $barang->kategori == 'Kamera' ? '📷' : ($barang->kategori == 'Alat Camping' ? '⛺' : '📦') }} {{ $barang->kategori }}
                        </span>
                    </td>
                    <td class="px-4 py-3">Rp {{ number_format($barang->harga_sewa,0,',','.') }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs {{ $barang->stok>0?'bg-green-100 text-green-700':'bg-red-100 text-red-700' }}">
                            {{ $barang->stok>0?'Stok: '.$barang->stok:'Habis' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <button onclick="editBarang({{ $barang->id }}, '{{ $barang->nama_barang }}', '{{ $barang->kategori }}', '{{ $barang->deskripsi }}', {{ $barang->harga_sewa }}, {{ $barang->stok }})" class="text-blue-600 hover:text-blue-800 mr-2"><i class="fas fa-edit"></i></button>
                        <button onclick="hapusBarang({{ $barang->id }})" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ==================== MODAL TAMBAH BARANG ==================== --}}
<div id="tambahBarangModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold"><i class="fas fa-plus-circle text-green-600 mr-2"></i>Tambah Barang</h2>
            <button onclick="closeModal('tambahBarangModal')" class="text-gray-400 text-2xl">&times;</button>
        </div>
        <form onsubmit="event.preventDefault(); alert('Barang berhasil ditambahkan!'); closeModal('tambahBarangModal');">
            <div class="space-y-3">
                <div><label class="block text-sm font-semibold mb-1">Nama Barang</label><input type="text" placeholder="Contoh: Kamera Canon EOS 200D" class="w-full border rounded-lg px-3 py-2" required></div>
                <div><label class="block text-sm font-semibold mb-1">Foto Barang</label><input type="file" class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="block text-sm font-semibold mb-1">Kategori</label>
                    <select class="w-full border rounded-lg px-3 py-2" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Kamera">📷 Kamera</option>
                        <option value="Alat Camping">⛺ Alat Camping</option>
                        <option value="Paket">📦 Paket</option>
                    </select>
                </div>
                <div><label class="block text-sm font-semibold mb-1">Deskripsi</label><textarea rows="3" placeholder="Deskripsi barang..." class="w-full border rounded-lg px-3 py-2"></textarea></div>
                <div><label class="block text-sm font-semibold mb-1">Harga Sewa per Hari</label><input type="number" placeholder="150000" class="w-full border rounded-lg px-3 py-2" required></div>
                <div><label class="block text-sm font-semibold mb-1">Stok</label><input type="number" placeholder="5" class="w-full border rounded-lg px-3 py-2" required></div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700">Simpan</button>
                <button type="button" onclick="closeModal('tambahBarangModal')" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg font-semibold hover:bg-gray-400">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== MODAL EDIT BARANG ==================== --}}
<div id="editBarangModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold"><i class="fas fa-edit text-blue-600 mr-2"></i>Edit Barang</h2>
            <button onclick="closeModal('editBarangModal')" class="text-gray-400 text-2xl">&times;</button>
        </div>
        <form onsubmit="event.preventDefault(); alert('Barang berhasil diupdate!'); closeModal('editBarangModal');">
            <div class="space-y-3">
                <div><label class="block text-sm font-semibold mb-1">Nama Barang</label><input type="text" id="editNamaBarang" class="w-full border rounded-lg px-3 py-2" required></div>
                <div><label class="block text-sm font-semibold mb-1">Foto Barang</label><input type="file" class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="block text-sm font-semibold mb-1">Kategori</label><select id="editKategori" class="w-full border rounded-lg px-3 py-2" required><option value="Kamera">📷 Kamera</option><option value="Alat Camping">⛺ Alat Camping</option><option value="Paket">📦 Paket</option></select></div>
                <div><label class="block text-sm font-semibold mb-1">Deskripsi</label><textarea id="editDeskripsi" rows="3" class="w-full border rounded-lg px-3 py-2"></textarea></div>
                <div><label class="block text-sm font-semibold mb-1">Harga Sewa per Hari</label><input type="number" id="editHarga" class="w-full border rounded-lg px-3 py-2" required></div>
                <div><label class="block text-sm font-semibold mb-1">Stok</label><input type="number" id="editStok" class="w-full border rounded-lg px-3 py-2" required></div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700">Update</button>
                <button type="button" onclick="closeModal('editBarangModal')" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg font-semibold hover:bg-gray-400">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== SCRIPT ==================== --}}
<script>
function openModal(id) { document.getElementById(id).classList.remove('hidden'); document.getElementById(id).classList.add('flex'); }
function closeModal(id) { document.getElementById(id).classList.add('hidden'); document.getElementById(id).classList.remove('flex'); }

function editBarang(id, nama, kategori, deskripsi, harga, stok) {
    document.getElementById('editNamaBarang').value = nama;
    document.getElementById('editKategori').value = kategori;
    document.getElementById('editDeskripsi').value = deskripsi;
    document.getElementById('editHarga').value = harga;
    document.getElementById('editStok').value = stok;
    openModal('editBarangModal');
}

function hapusBarang(id) { 
    if(confirm('Yakin ingin menghapus barang ini?')) {
        alert('Barang berhasil dihapus!');
    }
}
</script>
@endsection