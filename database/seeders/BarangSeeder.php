<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangs = [
            ['nama_barang' => 'Kamera Canon EOS 200D', 'kategori' => 'Kamera', 'harga_sewa' => 150000, 'stok' => 3, 'deskripsi' => 'Kamera DSLR entry level', 'foto' => 'images/barang/canon.jpg'],
            ['nama_barang' => 'Kamera Sony A6400', 'kategori' => 'Kamera', 'harga_sewa' => 200000, 'stok' => 2, 'deskripsi' => 'Kamera mirrorless autofocus cepat', 'foto' => 'images/barang/sony.jpg'],
            ['nama_barang' => 'Tenda 2 Orang', 'kategori' => 'Alat Camping', 'harga_sewa' => 75000, 'stok' => 5, 'deskripsi' => 'Tenda kapasitas 2 orang anti air', 'foto' => 'images/barang/Tenda.jpg'],
            ['nama_barang' => 'kompor', 'kategori' => 'Alat Camping', 'harga_sewa' => 35000, 'stok' => 10, 'deskripsi' => 'Kompor portable untuk camping', 'foto' => 'images/barang/kompor.jpg'],
            ['nama_barang' => 'Paket 1', 'kategori' => 'Paket', 'harga_sewa' => 350000, 'stok' => 2, 'deskripsi' => 'Paket hemat: Tenda + Sleeping Bag + Kompor + kursi', 'foto' => 'images/barang/paket.jpg'],
            ['nama_barang' => 'Paket 2', 'kategori' => 'Paket', 'harga_sewa' => 200000, 'stok' => 3, 'deskripsi' => 'Paket hemat: Tenda + Sleeping Bag + Kompor', 'foto' => 'images/barang/paket.jpg']
        ];

        foreach ($barangs as $barang) {
            Barang::create($barang);
        }
    }
}
