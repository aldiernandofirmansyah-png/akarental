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
<li><a href="{{ route('pelanggan.dashboard') }}" class="block px-4 py-3 rounded-lg sidebar-active"><i class="fas fa-tachometer-alt mr-3"></i> Dashboard</a></li>
<li><a href="{{ route('pelanggan.riwayat_sewa') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition text-gray-700 font-medium"><i class="fas fa-history mr-3"></i> Riwayat Sewa</a></li>
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- ==================== SAPAAN USER ==================== --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800"><i class="fas fa-camera text-purple-600 mr-2"></i>Dashboard Pelanggan</h1>
    <p class="text-purple-600 font-bold mt-1"><i class="fas fa-user-circle mr-1"></i> Selamat Datang, {{ auth()->user()->name }}</p>
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
        <button onclick="resetFilter()" class="bg-gray-500 text-white px-5 py-2 rounded-lg hover:bg-gray-600"><i class="fas fa-undo mr-1"></i> Reset Filter</button>
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
                        <p class="text-xs text-gray-400 mt-2">Tidak Ada Gambar</p>
                    @elseif($barang->kategori == 'Alat Camping')
                        <i class="fas fa-campground text-5xl text-gray-400"></i>
                        <p class="text-xs text-gray-400 mt-2">Tidak Ada Gambar</p>
                    @else
                        <i class="fas fa-gift text-5xl text-gray-400"></i>
                        <p class="text-xs text-gray-400 mt-2">Tidak Ada Gambar</p>
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
                    <div><label class="block text-xs font-semibold mb-1">Nama Lengkap</label><input type="text" value="{{ auth()->user()->name }}" class="w-full border rounded-lg px-3 py-2 text-sm bg-gray-100 cursor-not-allowed" readonly></div>
                    <div><label class="block text-xs font-semibold mb-1">Email</label><input type="email" value="{{ auth()->user()->email }}" class="w-full border rounded-lg px-3 py-2 text-sm bg-gray-100 cursor-not-allowed" readonly></div>
                    <div><label class="block text-xs font-semibold mb-1">No. Handphone (WhatsApp) <span class="text-red-500">*</span></label><input type="tel" id="bookingNoTelp" value="{{ auth()->user()->no_telp }}" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Contoh: 08123456789" required></div>
                </div>
            </div>
            
            {{-- Detail Sewa --}}
            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                <p class="text-sm font-semibold text-gray-700 mb-2"><i class="fas fa-calendar-alt mr-1"></i> Detail Sewa</p>
                <div class="grid grid-cols-2 gap-3">
                    <div><label class="block text-xs font-semibold mb-1">Tanggal Mulai <span class="text-red-500">*</span></label><input type="date" id="tanggalMulai" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full border rounded-lg px-3 py-2 text-sm" required></div>
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
            <div class="bg-purple-50 rounded-2xl p-4 mb-4 border border-purple-100">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-semibold text-gray-600">Total Sewa:</span>
                    <span class="text-lg font-bold text-gray-800" id="totalBiayaBooking">Rp 0</span>
                </div>
                <div class="flex justify-between items-center mb-2 p-2 bg-yellow-100/50 rounded-lg border border-yellow-200">
                    <span class="text-sm font-bold text-yellow-700">Wajib DP (30%):</span>
                    <span class="text-lg font-extrabold text-yellow-700" id="dpAmount">Rp 0</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs font-medium text-gray-500">Sisa Bayar di Toko:</span>
                    <span class="text-sm font-bold text-gray-600" id="sisaBayar">Rp 0</span>
                </div>
                <p class="text-[10px] text-gray-500 mt-3 italic">*Booking dianggap valid setelah bukti transfer DP dikirim ke Admin.</p>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all"><i class="fas fa-check-circle mr-1"></i> Lanjut Pembayaran</button>
                <button type="button" onclick="closeModal('bookingModal')" class="flex-1 bg-gray-100 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-200 transition-all">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== MODAL KONFIRMASI BOOKING ==================== --}}
<div id="konfirmasiModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
        <div class="bg-emerald-600 px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-clock mr-3"></i> Menunggu DP
            </h2>
            <button onclick="closeModal('konfirmasiModal')" class="text-white/80 hover:text-white text-2xl">&times;</button>
        </div>
        
        <div class="p-6 space-y-4">
            <div class="text-center">
                <p class="text-sm text-gray-600">Silakan transfer DP untuk mengamankan barang Anda:</p>
                <h3 class="text-3xl font-black text-emerald-600 mt-2" id="detailDP">Rp 0</h3>
            </div>

            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Barang:</span> <span id="detailBarang" class="font-bold"></span></div>
                <div class="flex justify-between"><span class="text-gray-500">Total Sewa:</span> <span id="detailTotal" class="font-bold"></span></div>
                <div class="flex justify-between border-t pt-2 mt-2"><span class="text-gray-500">Sisa Pelunasan:</span> <span id="detailSisa" class="font-bold text-gray-700"></span></div>
            </div>
            
            <div class="bg-blue-50 rounded-2xl p-4 border border-blue-100">
                <p class="text-xs font-bold text-blue-700 mb-2 uppercase tracking-wider">Transfer Ke:</p>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-800">BCA 8210914073</p>
                        <p class="text-xs text-gray-500">a.n AKA Rental (Aldi)</p>
                    </div>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/1200px-Bank_Central_Asia.svg.png" class="h-4">
                </div>
            </div>
            
            <a href="#" id="whatsappLink" target="_blank" class="block w-full bg-green-600 text-white py-3 rounded-xl font-bold hover:bg-green-700 text-center shadow-lg shadow-green-200 transition-all">
                <i class="fab fa-whatsapp mr-2 text-lg"></i> Kirim Bukti Transfer
            </a>
            
            <p class="text-[10px] text-center text-gray-400 font-medium">Pesanan akan dibatalkan otomatis jika DP tidak dibayar dalam 1 jam.</p>
        </div>
    </div>
</div>

{{-- ==================== SCRIPT ==================== --}}
<script>
let currentHarga = 0;
let currentBarangNama = '';
const DP_PERCENT = 0.3; // 30% DP

function openBookingModal(id, nama, harga) {
    document.getElementById('bookingBarangId').value = id;
    document.getElementById('bookingBarangNama').innerText = nama;
    document.getElementById('bookingBarangHarga').innerText = harga.toLocaleString('id-ID');
    currentHarga = harga;
    currentBarangNama = nama;
    
    // Set minimum date to today
    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0');
    let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    let yyyy = today.getFullYear();
    let minDate = yyyy + '-' + mm + '-' + dd;
    
    document.getElementById('tanggalMulai').setAttribute('min', minDate);
    document.getElementById('tanggalKembali').setAttribute('min', minDate);
    
    // Reset inputs
    document.getElementById('tanggalMulai').value = '';
    document.getElementById('tanggalKembali').value = '';
    document.getElementById('jumlahBooking').value = '1';
    
    hitungTotal();
    openModal('bookingModal');
}

function hitungTotal() {
    let mulaiInput = document.getElementById('tanggalMulai');
    let kembaliInput = document.getElementById('tanggalKembali');
    let mulai = mulaiInput.value;
    let kembali = kembaliInput.value;
    
    // Pastikan tanggal kembali tidak sebelum tanggal mulai
    if (mulai) {
        kembaliInput.setAttribute('min', mulai);
    }

    let jumlah = parseInt(document.getElementById('jumlahBooking').value) || 1;
    let totalSewa = currentHarga * jumlah;
    
    if(mulai && kembali) {
        let diffTime = new Date(kembali) - new Date(mulai);
        let hari = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        if(hari > 0) {
            totalSewa = hari * currentHarga * jumlah;
        } else if (hari === 0) {
            totalSewa = 1 * currentHarga * jumlah; // Minimal 1 hari
        }
    }
    
    let dpAmount = totalSewa * DP_PERCENT;
    let sisaBayar = totalSewa - dpAmount;
    
    document.getElementById('totalBiayaBooking').innerText = 'Rp ' + Math.round(totalSewa).toLocaleString('id-ID');
    document.getElementById('dpAmount').innerText = 'Rp ' + Math.round(dpAmount).toLocaleString('id-ID');
    document.getElementById('sisaBayar').innerText = 'Rp ' + Math.round(sisaBayar).toLocaleString('id-ID');
}

function bookingSelesai() {
    let barangId = document.getElementById('bookingBarangId').value;
    let mulai = document.getElementById('tanggalMulai').value;
    let kembali = document.getElementById('tanggalKembali').value;
    let jumlah = document.getElementById('jumlahBooking').value;
    let noTelp = document.getElementById('bookingNoTelp').value;
    
    if(!mulai || !kembali) {
        alert('Harap isi tanggal sewa!');
        return;
    }

    if(!noTelp) {
        alert('Harap isi nomor WhatsApp!');
        return;
    }

    // Tampilkan loading state jika perlu
    const submitBtn = document.querySelector('#bookingModal button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...';

    // Kirim data ke server via AJAX
    fetch('{{ route("pelanggan.booking.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            barang_id: barangId,
            tanggal_mulai: mulai,
            tanggal_kembali: kembali,
            jumlah: jumlah,
            no_telp: noTelp
        })
    })
    .then(async response => {
        const data = await response.json();
        if(!response.ok) {
            throw new Error(data.message || 'Terjadi kesalahan pada server');
        }
        return data;
    })
    .then(data => {
        if(data.success) {
            let totalSewaTxt = 'Rp ' + Math.round(data.total_biaya).toLocaleString('id-ID');
            let dpTxt = 'Rp ' + Math.round(data.dp_amount).toLocaleString('id-ID');
            let sisaTxt = 'Rp ' + Math.round(data.sisa_bayar).toLocaleString('id-ID');

            document.getElementById('detailBarang').innerText = currentBarangNama;
            document.getElementById('detailTotal').innerText = totalSewaTxt;
            document.getElementById('detailDP').innerText = dpTxt;
            document.getElementById('detailSisa').innerText = sisaTxt;
            
            let pesanWA = `Halo Admin AKA Rental,%0A%0A` +
                          `Saya ingin konfirmasi booking (ID: #AK${1000 + data.booking_id}):%0A` +
                          `----------------------------------%0A` +
                          `👤 Nama: {{ auth()->user()->name }}%0A` +
                          `📞 No. WA: ${noTelp}%0A` +
                          `📦 Barang: ${currentBarangNama}%0A` +
                          `📅 Periode: ${mulai} s/d ${kembali}%0A` +
                          `💰 Total Sewa: ${totalSewaTxt}%0A` +
                          `💳 *Wajib DP (30%): ${dpTxt}*%0A` +
                          `💵 Sisa Bayar: ${sisaTxt}%0A` +
                          `----------------------------------%0A%0A` +
                          `Saya akan segera mengirimkan bukti transfer DP ke BCA 8210914073 a.n AKA Rental. Mohon dicek ya!`;
            
            document.getElementById('whatsappLink').href = `https://wa.me/6282170244177?text=${pesanWA}`;
            
            closeModal('bookingModal');
            openModal('konfirmasiModal');
        } else {
            alert('Gagal membuat booking: ' + (data.message || 'Silakan coba lagi.'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal: ' + error.message);
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    });
}

document.getElementById('tanggalMulai')?.addEventListener('change', hitungTotal);
document.getElementById('tanggalKembali')?.addEventListener('change', hitungTotal);
document.getElementById('jumlahBooking')?.addEventListener('change', hitungTotal);

function resetFilter() {
    document.getElementById('kategoriFilter').value = 'semua';
    document.getElementById('paketFilter').value = 'semua';
    document.getElementById('cariBarang').value = '';
    filterBarang();
}

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
        
        // Filter Kategori
        if(kategori !== 'semua' && kat !== kategori) tampil = false;
        
        // Filter Paket
        if(paket === 'paket' && tipePaket !== 'paket') tampil = false;
        
        // Filter Pencarian Nama
        if(cari && !nama.includes(cari)) tampil = false;
        
        item.style.display = tampil ? 'block' : 'none';
        if(tampil) ada = true;
    });
    
    document.getElementById('emptyMessage').style.display = ada ? 'none' : 'block';
}

// Tambahkan event listener agar pencarian bisa dilakukan sambil mengetik (real-time)
document.getElementById('cariBarang')?.addEventListener('keyup', filterBarang);
document.getElementById('kategoriFilter')?.addEventListener('change', filterBarang);
document.getElementById('paketFilter')?.addEventListener('change', filterBarang);

// Gunakan fungsi dari layout agar tidak bentrok
// function openModal(id) { ... }
// function closeModal(id) { ... }
</script>
@endsection