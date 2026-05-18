<?php

namespace App\Class;

abstract class BarangRental {

    protected $namaBarang;
    protected $hargaSewa;

    abstract public function tampilDetail();

}