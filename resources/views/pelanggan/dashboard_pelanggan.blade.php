{{-- 
=================================================================
 FILE: pelanggan/dashboard_pelanggan.blade.php
 FUNGSI: Halaman dashboard untuk PELANGGAN
 FITUR: 
   - Filter kategori (Kamera & Alat Camping)
   - Filter paket (Paket saja)
   - Pencarian barang
   - Grid daftar barang dengan gambar
   - Modal booking dengan hitung biaya otomatis
   - Modal konfirmasi booking dengan link WhatsApp
 DATA: Dikirim dari PelangganController (compact 'barangsPelanggan')
=================================================================
--}}

@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('sidebar_menu')
<li><a href="/pelanggan/dashboard" onclick="showPelangganDashboard()" class="block px-4 py-3 rounded-lg sidebar-active"><i class="fas fa-tachometer-alt mr-3"></i> Dashboard</a></li>
<li><a href="/pelanggan/riwayat-sewa" onclick="showPelangganRiwayat()" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition"><i class="fas fa-history mr-3"></i> Riwayat Sewa</a></li>
@endsection

@section('content')

{{-- ==================== SAPAAN USER ==================== --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800"><i class="fas fa-camera text-purple-600 mr-2"></i>Dashboard Pelanggan</h1>
    <p class="text-purple-600 font-bold mt-1"><i class="fas fa-user-circle mr-1"></i> Selamat Datang, Pelanggan User</p>
</div>

{{-- ==================== FILTER ==================== --}}
<div class="bg-white rounded-xl shadow-lg p-4 mb-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-semibold mb-1"><i class="fas fa-tag mr-1"></i> Kategori</label>
            <select id="kategoriFilter" class="w-full border rounded-lg px-4 py-2">
                <option value="semua">Semua Kategori</option>
                <option value="Kamera">📷 Kamera</option>
                <option value="Alat Camping">⛺ Alat Camping</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-semibold mb-1"><i class="fas fa-gift mr-1"></i> Filter Paket</label>
            <select id="paketFilter" class="w-full border rounded-lg px-4 py-2">
                <option value="semua">Semua Barang</option>
                <option value="paket">📦 Paket</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-semibold mb-1"><i class="fas fa-search mr-1"></i> Cari Barang</label>
            <input type="text" id="cariBarang" placeholder="Cari nama barang..." class="w-full border rounded-lg px-4 py-2">
        </div>
    </div>
    <div class="flex gap-3 mt-4">
        <button onclick="filterBarang()" class="bg-purple-600 text-white px-5 py-2 rounded-lg hover:bg-purple-700"><i class="fas fa-search mr-1"></i> Cari</button>
        <button onclick="resetFilter()" class="bg-gray-500 text-white px-5 py-2 rounded-lg hover:bg-gray-600"><i class="fas fa-undo mr-1"></i> Reset</button>
    </div>
</div>

{{-- ==================== GRID BARANG ==================== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="barangGrid">
    @foreach($barangsPelanggan as $barang)
    <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover" 
         data-kategori="{{ $barang->kategori }}" 
         data-nama="{{ strtolower($barang->nama_barang) }}" 
         data-paket="{{ $barang->kategori == 'Paket' ? 'paket' : 'biasa' }}">
        
        {{-- Area Foto --}}
        <div class="h-48 bg-gray-200 flex items-center justify-center relative overflow-hidden">
            @php
                $fotoPath = public_path($barang->foto);
                $fotoExists = !empty($barang->foto) && file_exists($fotoPath);
            @endphp
            
            @if($fotoExists)
                <img src="{{ asset($barang->foto) }}" alt="{{ $barang->nama_barang }}" class="w-full h-full object-cover">
            @else
                <div class="text-center">
                    @if($barang->kategori == 'Kamera')
                        <i class="fas fa-camera text-5xl text-gray-400"></i>
                        <p class="text-xs text-gray-400 mt-2">No Image</p>
                    @elseif($barang->kategori == 'Alat Camping')
                        <i class="fas fa-campground text-5xl text-gray-400"></i>
                        <p class="text-xs text-gray-400 mt-2">No Image</p>
                    @else
                        <i class="fas fa-gift text-5xl text-gray-400"></i>
                        <p class="text-xs text-gray-400 mt-2">No Image</p>
                    @endif
                </div>
            @endif
            
            {{-- Badge Stok --}}
            <div class="absolute top-3 right-3">
                <span class="px-2 py-1 rounded-full text-xs {{ $barang->stok>0?'bg-green-500 text-white':'bg-red-500 text-white' }}">
                    {{ $barang->stok>0?'Stok: '.$barang->stok:'Habis' }}
                </span>
            </div>
            
            {{-- Badge Paket --}}
            @if($barang->kategori == 'Paket')
            <div class="absolute top-3 left-3">
                <span class="px-2 py-1 rounded-full text-xs bg-purple-500 text-white">
                    <i class="fas fa-gift mr-1"></i>Paket
                </span>
            </div>
            @endif
        </div>
        
        <div class="p-4">
            <div class="mb-2">
                <span class="px-2 py-1 rounded-full text-xs 
                    {{ $barang->kategori == 'Kamera' ? 'bg-blue-100 text-blue-700' : ($barang->kategori == 'Alat Camping' ? 'bg-green-100 text-green-700' : 'bg-purple-100 text-purple-700') }}">
                    {{ $barang->kategori == 'Kamera' ? '📷' : ($barang->kategori == 'Alat Camping' ? '⛺' : '📦') }} {{ $barang->kategori }}
                </span>
            </div>
            <h3 class="font-bold text-lg">{{ $barang->nama_barang }}</h3>
            <p class="text-gray-500 text-sm mb-3">{{ Str::limit($barang->deskripsi, 50) }}</p>
            <div class="mb-3">
                <span class="text-purple-600 font-bold text-xl">Rp {{ number_format($barang->harga_sewa,0,',','.') }}</span>
                <span class="text-gray-500 text-sm">/hari</span>
            </div>
            <button onclick="openBookingModal({{ $barang->id }}, '{{ $barang->nama_barang }}', {{ $barang->harga_sewa }})" 
                class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700 transition {{ $barang->stok<1?'opacity-50 cursor-not-allowed':'' }}" 
                {{ $barang->stok<1?'disabled':'' }}>
                <i class="fas fa-calendar-check mr-1"></i> Booking
            </button>
        </div>
    </div>
    @endforeach
</div>

<div id="emptyMessage" class="hidden text-center py-12 text-gray-500">
    <i class="fas fa-box-open text-5xl mb-3 opacity-50"></i>
    <p>Tidak ada barang yang sesuai dengan filter</p>
</div>

{{-- ==================== MODAL BOOKING ==================== --}}
<div id="bookingModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-lg max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold"><i class="fas fa-calendar-plus text-blue-600 mr-2"></i>Form Booking</h2>
            <button onclick="closeModal('bookingModal')" class="text-gray-400 text-2xl">&times;</button>
        </div>
        
        <form onsubmit="event.preventDefault(); bookingSelesai();">
            {{-- Data Barang --}}
            <div class="bg-blue-50 rounded-lg p-3 mb-4">
                <p class="text-sm font-semibold text-blue-700"><i class="fas fa-box mr-1"></i> Detail Barang</p>
                <input type="hidden" id="bookingBarangId">
                <div class="mt-2">
                    <p><span class="font-semibold">Barang:</span> <span id="bookingBarangNama"></span></p>
                    <p><span class="font-semibold">Harga:</span> Rp <span id="bookingBarangHarga"></span>/hari</p>
                </div>
            </div>
            
            {{-- Data Diri --}}
            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                <p class="text-sm font-semibold text-gray-700 mb-2"><i class="fas fa-user mr-1"></i> Data Diri Pelanggan</p>
                <div class="space-y-3">
                    <div><label class="block text-xs font-semibold mb-1">Nama Lengkap <span class="text-red-500">*</span></label><input type="text" id="pelangganNama" placeholder="Masukkan nama lengkap" class="w-full border rounded-lg px-3 py-2 text-sm" required></div>
                    <div><label class="block text-xs font-semibold mb-1">Email <span class="text-red-500">*</span></label><input type="email" id="pelangganEmail" placeholder="email@example.com" class="w-full border rounded-lg px-3 py-2 text-sm" required></div>
                    <div><label class="block text-xs font-semibold mb-1">No. Handphone (WhatsApp) <span class="text-red-500">*</span></label><input type="tel" id="pelangganNoHp" placeholder="081234567890" class="w-full border rounded-lg px-3 py-2 text-sm" required></div>
                </div>
            </div>
            
            {{-- Detail Sewa --}}
            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                <p class="text-sm font-semibold text-gray-700 mb-2"><i class="fas fa-calendar-alt mr-1"></i> Detail Sewa</p>
                <div class="grid grid-cols-2 gap-3">
                    <div><label class="block text-xs font-semibold mb-1">Tanggal Mulai <span class="text-red-500">*</span></label><input type="date" id="tanggalMulai" class="w-full border rounded-lg px-3 py-2 text-sm" required></div>
                    <div><label class="block text-xs font-semibold mb-1">Tanggal Kembali <span class="text-red-500">*</span></label><input type="date" id="tanggalKembali" class="w-full border rounded-lg px-3 py-2 text-sm" required></div>
                    <div><label class="block text-xs font-semibold mb-1">Jumlah <span class="text-red-500">*</span></label><input type="number" id="jumlahBooking" value="1" min="1" class="w-full border rounded-lg px-3 py-2 text-sm" required></div>
                </div>
            </div>
            
            {{-- Lokasi Pengambilan --}}
            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                <p class="text-sm font-semibold text-gray-700 mb-2"><i class="fas fa-map-marker-alt mr-1"></i> Lokasi Pengambilan Barang</p>
                <div class="bg-green-50 rounded-lg p-3 border border-green-200">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-store text-green-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-green-700">Ambil di Toko</p>
                            <p class="text-sm text-gray-600">Jl. Perkasa Blok 2 No.18 (Di Jodoh dekat rumah kepin)</p>
                            <p class="text-xs text-gray-500 mt-1">Jam Operasional: 08.00 - 20.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Informasi KTP --}}
            <div class="bg-yellow-50 rounded-lg p-3 mb-4 border border-yellow-200">
                <div class="flex gap-2">
                    <i class="fas fa-id-card text-yellow-600 text-xl"></i>
                    <div>
                        <p class="text-sm font-semibold text-yellow-700">Informasi Jaminan</p>
                        <p class="text-xs text-yellow-600 mt-1">⚠️ KTP asli akan diserahkan saat mengambil barang dan akan dikembalikan setelah barang dikembalikan dengan kondisi baik.</p>
                    </div>
                </div>
            </div>
            
            {{-- Total Biaya --}}
            <div class="bg-purple-50 rounded-lg p-3 mb-4">
                <div class="flex justify-between items-center">
                    <span class="font-semibold">Total Biaya Sewa:</span>
                    <span class="text-2xl font-bold text-purple-600" id="totalBiayaBooking">Rp 0</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">*Pembayaran dapat dilakukan saat mengambil barang di toko</p>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700"><i class="fas fa-check-circle mr-1"></i> Konfirmasi Booking</button>
                <button type="button" onclick="closeModal('bookingModal')" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg font-semibold hover:bg-gray-400">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== MODAL KONFIRMASI BOOKING ==================== --}}
<div id="konfirmasiModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold"><i class="fas fa-check-circle text-green-600 mr-2"></i>Booking Berhasil!</h2>
            <button onclick="closeModal('konfirmasiModal')" class="text-gray-400 text-2xl">&times;</button>
        </div>
        
        <div class="space-y-4">
            <div class="bg-green-50 rounded-lg p-4 text-center">
                <i class="fas fa-calendar-check text-green-600 text-5xl mb-2"></i>
                <p class="font-semibold text-green-700">Booking Anda telah kami terima!</p>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm font-semibold mb-2">Rincian Booking:</p>
                <p><span class="text-gray-500">Barang:</span> <span id="detailBarang"></span></p>
                <p><span class="text-gray-500">Nama:</span> <span id="detailNama"></span></p>
                <p><span class="text-gray-500">No. HP:</span> <span id="detailNoHp"></span></p>
                <p><span class="text-gray-500">Tanggal Sewa:</span> <span id="detailTglMulai"></span> - <span id="detailTglKembali"></span></p>
                <p><span class="text-gray-500">Total Bayar:</span> <span id="detailTotal" class="font-bold text-green-600"></span></p>
            </div>
            
            {{-- Informasi Pembayaran --}}
            <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                <p class="text-sm font-semibold text-purple-700 mb-2"><i class="fas fa-credit-card mr-1"></i> Metode Pembayaran</p>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center gap-2"><i class="fas fa-money-bill-wave text-green-600"></i><span><span class="font-semibold">Tunai:</span> Bayar langsung saat mengambil barang</span></div>
                    <div class="flex items-center gap-2"><i class="fas fa-qrcode text-blue-600"></i><span><span class="font-semibold">QRIS:</span> Scan QR code (OVO, DANA, ShopeePay, dll)</span></div>
                    <div class="flex items-center gap-2"><i class="fas fa-university text-red-600"></i><span><span class="font-semibold">Transfer Bank:</span> BCA 8210914073 a.n AKA Rental</span></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">*Pembayaran dilakukan saat mengambil barang di toko</p>
            </div>
            
            <div class="bg-blue-50 rounded-lg p-4">
                <p class="text-sm font-semibold text-blue-700"><i class="fas fa-store mr-1"></i> Pengambilan Barang</p>
                <p class="text-sm mt-1">Silakan datang ke toko kami:</p>
                <p class="font-semibold mt-2">📍 Jl. Kampus No. 123 (Dekat Gerbang Utara Kampus)</p>
                <p class="text-sm">⏰ Jam Operasional: 08.00 - 20.00 WIB</p>
                <p class="text-sm mt-2">📌 Jangan lupa membawa KTP asli untuk jaminan!</p>
            </div>
            
            {{-- Tombol WhatsApp --}}
            <a href="#" id="whatsappLink" target="_blank" class="block w-full bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700 text-center"><i class="fab fa-whatsapp mr-1"></i> Konfirmasi ke Admin via WhatsApp</a>
            
            <button onclick="closeModal('konfirmasiModal')" class="w-full bg-gray-300 text-gray-700 py-2 rounded-lg font-semibold hover:bg-gray-400">Tutup</button>
        </div>
    </div>
</div>

{{-- ==================== SCRIPT ==================== --}}
<script>
let currentHarga = 0;
let currentBarangNama = '';

function openBookingModal(id, nama, harga) {
    document.getElementById('bookingBarangId').value = id;
    document.getElementById('bookingBarangNama').innerText = nama;
    document.getElementById('bookingBarangHarga').innerText = harga.toLocaleString('id-ID');
    currentHarga = harga;
    currentBarangNama = nama;
    
    document.getElementById('pelangganNama').value = '';
    document.getElementById('pelangganEmail').value = '';
    document.getElementById('pelangganNoHp').value = '';
    document.getElementById('tanggalMulai').value = '';
    document.getElementById('tanggalKembali').value = '';
    document.getElementById('jumlahBooking').value = '1';
    
    hitungTotal();
    openModal('bookingModal');
}

function hitungTotal() {
    let mulai = document.getElementById('tanggalMulai').value;
    let kembali = document.getElementById('tanggalKembali').value;
    let jumlah = parseInt(document.getElementById('jumlahBooking').value) || 1;
    let totalSewa = 0;
    
    if(mulai && kembali) {
        let hari = Math.ceil((new Date(kembali) - new Date(mulai)) / (1000 * 60 * 60 * 24));
        if(hari > 0) {
            totalSewa = hari * currentHarga * jumlah;
        } else {
            totalSewa = currentHarga * jumlah;
        }
    } else {
        totalSewa = currentHarga;
    }
    
    document.getElementById('totalBiayaBooking').innerText = 'Rp ' + totalSewa.toLocaleString('id-ID');
}

function bookingSelesai() {
    let nama = document.getElementById('pelangganNama').value;
    let email = document.getElementById('pelangganEmail').value;
    let noHp = document.getElementById('pelangganNoHp').value;
    let mulai = document.getElementById('tanggalMulai').value;
    let kembali = document.getElementById('tanggalKembali').value;
    
    if(!nama || !email || !noHp || !mulai || !kembali) {
        alert('Harap isi semua field yang wajib diisi!');
        return;
    }
    
    document.getElementById('detailBarang').innerText = currentBarangNama;
    document.getElementById('detailNama').innerText = nama;
    document.getElementById('detailNoHp').innerText = noHp;
    document.getElementById('detailTglMulai').innerText = mulai;
    document.getElementById('detailTglKembali').innerText = kembali;
    document.getElementById('detailTotal').innerText = document.getElementById('totalBiayaBooking').innerText;
    
    let pesanWA = `Halo Admin, saya ingin konfirmasi booking saya:%0A%0A` +
                  `📌 Nama: ${nama}%0A` +
                  `📞 No. HP: ${noHp}%0A` +
                  `📦 Barang: ${currentBarangNama}%0A` +
                  `📅 Tanggal Sewa: ${mulai} - ${kembali}%0A` +
                  `💰 Total: ${document.getElementById('totalBiayaBooking').innerText}%0A%0A` +
                  `Mohon dikonfirmasi ya. Terima kasih.`;
    
    let waLink = `https://wa.me/6281234567890?text=${pesanWA}`;
    document.getElementById('whatsappLink').href = waLink;
    
    closeModal('bookingModal');
    openModal('konfirmasiModal');
}

document.getElementById('tanggalMulai')?.addEventListener('change', hitungTotal);
document.getElementById('tanggalKembali')?.addEventListener('change', hitungTotal);
document.getElementById('jumlahBooking')?.addEventListener('change', hitungTotal);

function filterBarang() {
    let kategori = document.getElementById('kategoriFilter').value;
    let paket = document.getElementById('paketFilter').value;
    let cari = document.getElementById('cariBarang').value.toLowerCase();
    let items = document.querySelectorAll('#barangGrid > div');
    let ada = false;
    
    items.forEach(item => {
        let kat = item.getAttribute('data-kategori');
        let nama = item.getAttribute('data-nama');
        let tipePaket = item.getAttribute('data-paket');
        let tampil = true;
        
        if(kategori !== 'semua' && kat !== kategori) tampil = false;
        if(paket === 'paket' && tipePaket !== 'paket') tampil = false;
        if(cari && !nama.includes(cari)) tampil = false;
        
        item.style.display = tampil ? 'block' : 'none';
        if(tampil) ada = true;
    });
    
    document.getElementById('emptyMessage').style.display = ada ? 'none' : 'block';
}

function resetFilter() {
    document.getElementById('kategoriFilter').value = 'semua';
    document.getElementById('paketFilter').value = 'semua';
    document.getElementById('cariBarang').value = '';
    document.querySelectorAll('#barangGrid > div').forEach(item => item.style.display = 'block');
    document.getElementById('emptyMessage').style.display = 'none';
}

function openModal(id) { document.getElementById(id).classList.remove('hidden'); document.getElementById(id).classList.add('flex'); }
function closeModal(id) { document.getElementById(id).classList.add('hidden'); document.getElementById(id).classList.remove('flex'); }
</script>
@endsection