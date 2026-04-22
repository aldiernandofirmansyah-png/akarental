<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function dashboard()
    {
        // Data statis untuk demo
        $totalBarang = 25;
        $totalKamera = 5;
        $totalCamping = 15;
        $totalPaket = 5;
        $totalPelanggan = 5;
        $totalPendapatan = 12500000;

        $barangs = [
            (object) ['id' => 1, 'nama_barang' => 'Kamera Canon EOS 200D', 'kategori' => 'Kamera', 'harga_sewa' => 150000, 'stok' => 3, 'deskripsi' => 'Kamera DSLR entry level', 'foto' => '/images/barang/canon.jpg'],
            (object) ['id' => 2, 'nama_barang' => 'Kamera Sony A6400', 'kategori' => 'Kamera', 'harga_sewa' => 200000, 'stok' => 2, 'deskripsi' => 'Kamera mirrorless autofocus cepat', 'foto' => '/images/barang/sony.jpg'],
            (object) ['id' => 3, 'nama_barang' => 'Tenda 2 Orang', 'kategori' => 'Alat Camping', 'harga_sewa' => 75000, 'stok' => 5, 'deskripsi' => 'Tenda kapasitas 2 orang anti air', 'foto' => '/images/barang/tenda.jpg'],
            (object) ['id' => 4, 'nama_barang' => 'kompor', 'kategori' => 'Alat Camping', 'harga_sewa' => 35000, 'stok' => 10, 'deskripsi' => 'Kompor portable untuk camping', 'foto' => '/images/barang/kompor.jpg'],
            (object) ['id' => 5, 'nama_barang' => 'Paket 1', 'kategori' => 'Paket', 'harga_sewa' => 350000, 'stok' => 2, 'deskripsi' => 'Paket hemat: Tenda + Sleeping Bag + Kompor + kursi', 'foto' => '/images/barang/paket.jpg'],
            (object) ['id' => 6, 'nama_barang' => 'Paket 2', 'kategori' => 'Paket', 'harga_sewa' => 200000, 'stok' => 3, 'deskripsi' => 'Paket hemat: Tenda + Sleeping Bag + Kompor', 'foto' => '/images/barang/paket.jpg']
        ];

        return view('admin.dashboard_admin', compact(
            'totalBarang', 'totalKamera', 'totalCamping', 'totalPaket', 
            'totalPelanggan', 'totalPendapatan', 'barangs'
        ));
    }

    /**
     * Data Pelanggan
     */
    public function dataPelanggan()
    {
        $pelanggans = [
            (object) ['id' => 1, 'name' => 'Neymar Junior', 'email' => 'neymar@email.com', 'no_telp' => '081234567890', 'alamat' => 'Jl. Brasil No. 10', 'booking_aktif' => true, 'total_bayar' => 450000, 'denda' => 0],
            (object) ['id' => 2, 'name' => 'Lionel Messi', 'email' => 'messi@email.com', 'no_telp' => '081234567891', 'alamat' => 'Jl. Argentina No. 5', 'booking_aktif' => true, 'total_bayar' => 300000, 'denda' => 25000],
            (object) ['id' => 3, 'name' => 'Mesut Ozil', 'email' => 'ozil@email.com', 'no_telp' => '081234567892', 'alamat' => 'Jl. Jerman No. 15', 'booking_aktif' => false, 'total_bayar' => 600000, 'denda' => 0],
        ];

        return view('admin.data_pelanggan', compact('pelanggans'));
    }

    /**
     * Riwayat Sewa (Admin)
     */
    public function riwayatSewa()
    {
        $riwayatSewa = [
            (object) ['id' => 1, 'pelanggan' => 'Neymar Junior', 'barang' => 'Kamera Canon EOS 200D', 'tanggal_sewa' => '2026-04-10', 'tanggal_kembali' => '2026-04-13', 'status' => 'Aktif', 'total' => 450000],
            (object) ['id' => 2, 'pelanggan' => 'Mesut Ozil', 'barang' => 'Tenda 4 Orang', 'tanggal_sewa' => '2026-04-05', 'tanggal_kembali' => '2026-04-08', 'status' => 'Selesai', 'total' => 225000],
        ];

        return view('admin.riwayat_sewa_pelanggan', compact('riwayatSewa'));
    }
}