@extends('layouts.app')

@section('title', 'Perpanjangan Sewa')

@section('sidebar_menu')
<li><a href="/pelanggan/dashboard" onclick="showPelangganDashboard()" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition"><i class="fas fa-tachometer-alt mr-3"></i> Dashboard</a></li>
<li><a href="/pelanggan/riwayat-sewa" onclick="showPelangganRiwayat()" class="block px-4 py-3 rounded-lg sidebar-active"><i class="fas fa-history mr-3"></i> Riwayat Sewa</a></li>
@endsection

@section('content')

<?php
$sewa = (object) ['id' => 1, 'barang' => 'Kamera Canon EOS 200D', 'harga_sewa' => 150000, 'tanggal_mulai' => '2026-04-10', 'tanggal_kembali' => '2026-04-13'];
$dendaPerHari = 25000;
?>

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800"><i class="fas fa-calendar-plus text-purple-600 mr-2"></i>Perpanjangan Sewa</h1>
        <p class="text-purple-600 font-bold mt-1"><i class="fas fa-user-circle mr-1"></i> Selamat Datang, Pelanggan User</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
            <h2 class="text-xl font-bold">{{ $sewa->barang }}</h2>
            <p class="text-sm opacity-90">Perpanjang masa sewa barang Anda</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                <div><p class="text-sm text-gray-500">Tanggal Mulai</p><p class="font-semibold">{{ date('d/m/Y', strtotime($sewa->tanggal_mulai)) }}</p></div>
                <div><p class="text-sm text-gray-500">Tanggal Kembali Saat Ini</p><p class="font-semibold">{{ date('d/m/Y', strtotime($sewa->tanggal_kembali)) }}</p></div>
                <div><p class="text-sm text-gray-500">Harga Sewa/Hari</p><p class="font-semibold">Rp {{ number_format($sewa->harga_sewa,0,',','.') }}</p></div>
                <div><p class="text-sm text-gray-500">Denda per Hari</p><p class="font-semibold text-red-600">Rp {{ number_format($dendaPerHari,0,',','.') }}</p></div>
            </div>

            <form onsubmit="event.preventDefault(); alert('Perpanjangan berhasil!');">
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Perpanjang sampai tanggal</label>
                    <input type="date" id="tanggalBaru" class="w-full border rounded-lg px-4 py-3">
                </div>
                <div class="bg-yellow-50 rounded-lg p-4 mb-6">
                    <div class="flex justify-between"><span>Biaya Tambahan:</span><span id="biayaTambahan" class="font-semibold">Rp 0</span></div>
                    <div class="flex justify-between"><span>Denda Keterlambatan:</span><span id="dendaText" class="font-semibold text-red-600">Rp 0</span></div>
                    <div class="border-t pt-2 mt-2 flex justify-between"><span class="font-bold">Total yang harus dibayar:</span><span id="totalBayar" class="font-bold text-green-600 text-lg">Rp 0</span></div>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold">Konfirmasi Perpanjangan</button>
            </form>
        </div>
    </div>
</div>

<script>
const hargaPerHari = {{ $sewa->harga_sewa }};
const tanggalKembaliLama = '{{ $sewa->tanggal_kembali }}';
const dendaPerHari = {{ $dendaPerHari }};
document.getElementById('tanggalBaru').addEventListener('change', function() {
    const tanggalBaru = new Date(this.value);
    const tanggalLama = new Date(tanggalKembaliLama);
    if(tanggalBaru > tanggalLama) {
        const hariTambahan = Math.ceil((tanggalBaru - tanggalLama) / (1000*60*60*24));
        const biaya = hariTambahan * hargaPerHari;
        document.getElementById('biayaTambahan').innerText = 'Rp ' + biaya.toLocaleString('id-ID');
        const today = new Date();
        let denda = 0;
        if(today > tanggalLama) {
            const hariTelat = Math.ceil((today - tanggalLama) / (1000*60*60*24));
            denda = hariTelat * dendaPerHari;
        }
        document.getElementById('dendaText').innerText = 'Rp ' + denda.toLocaleString('id-ID');
        document.getElementById('totalBayar').innerText = 'Rp ' + (biaya + denda).toLocaleString('id-ID');
    } else {
        document.getElementById('biayaTambahan').innerText = 'Rp 0';
        document.getElementById('dendaText').innerText = 'Rp 0';
        document.getElementById('totalBayar').innerText = 'Rp 0';
    }
});
</script>
@endsection