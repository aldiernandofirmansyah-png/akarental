<?php

namespace App\Class;

use App\Class\User;

class Pelanggan extends User {

    public function lihatBarang() {
        return "Melihat daftar barang";
    }

    public function sewaBarang() {
        return "Menyewa barang";
    }
}