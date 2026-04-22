<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Dashboard Pelanggan
     */
    public function dashboard()
    {
        $barangsPelanggan = [
            (object) ['id' => 1, 'nama_barang' => 'Kamera Canon EOS 200D', 'kategori' => 'Kamera', 'harga_sewa' => 150000, 'stok' => 3, 'deskripsi' => 'Kamera DSLR entry level', 'foto' => '/images/barang/canon.jpg'],
            (object) ['id' => 2, 'nama_barang' => 'Kamera Sony A6400', 'kategori' => 'Kamera', 'harga_sewa' => 200000, 'stok' => 2, 'deskripsi' => 'Kamera mirrorless autofocus cepat', 'foto' => '/images/barang/sony.jpg'],
            (object) ['id' => 3, 'nama_barang' => 'Tenda 2 Orang', 'kategori' => 'Alat Camping', 'harga_sewa' => 75000, 'stok' => 5, 'deskripsi' => 'Tenda kapasitas 2 orang anti air', 'foto' => '/images/barang/tenda.jpg'],
            (object) ['id' => 4, 'nama_barang' => 'Kompor Portable', 'kategori' => 'Alat Camping', 'harga_sewa' => 35000, 'stok' => 10, 'deskripsi' => 'Kompor kecil untuk camping, mudah dibawa', 'foto' => '/images/barang/kompor.jpg'],
            (object) ['id' => 5, 'nama_barang' => 'Paket 1', 'kategori' => 'Paket', 'harga_sewa' => 350000, 'stok' => 2, 'deskripsi' => 'Paket hemat: Tenda + Sleeping Bag + Kompor + Kursi', 'foto' => '/images/barang/paket.jpg'],
            (object) ['id' => 6, 'nama_barang' => 'Paket 2', 'kategori' => 'Paket', 'harga_sewa' => 200000, 'stok' => 3, 'deskripsi' => 'Paket hemat: Tenda + Sleeping Bag + Kompor', 'foto' => '/images/barang/paket.jpg']
        ];

        return view('pelanggan.dashboard_pelanggan', compact('barangsPelanggan'));
    }

    /**
     * Riwayat Sewa Pelanggan
     */
    public function riwayatSewa()
    {
        $riwayatSaya = [
            (object) ['id' => 1, 'barang' => 'Kamera Canon EOS 200D', 'tanggal_mulai' => '2026-04-10', 'tanggal_kembali' => '2026-04-13', 'total_biaya' => 450000, 'status' => 'Aktif'],
            (object) ['id' => 2, 'barang' => 'Tenda 2 Orang', 'tanggal_mulai' => '2026-04-01', 'tanggal_kembali' => '2026-04-03', 'total_biaya' => 225000, 'status' => 'Selesai'],
        ];

        return view('pelanggan.riwayat_sewa', compact('riwayatSaya'));
    }

    /**
     * Halaman Perpanjangan
     */
    public function perpanjangan($id)
    {
        $sewa = (object) ['id' => 1, 'barang' => 'Kamera Canon EOS 200D', 'harga_sewa' => 150000, 'tanggal_mulai' => '2026-04-10', 'tanggal_kembali' => '2026-04-13'];
        $dendaPerHari = 25000;

        return view('pelanggan.perpanjangan', compact('sewa', 'dendaPerHari'));
    }
}