<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'barang_id',
        'kode_barang_fisik',
        'tanggal_mulai',
        'tanggal_kembali',
        'jumlah',
        'total_biaya',
        'dp_amount',
        'sisa_bayar',
        'denda',
        'status_pembayaran',
        'waktu_bayar_dp',
        'waktu_bayar_lunas',
        'status_sewa',
        'catatan',
    ];

    protected $casts = [
        'waktu_bayar_dp' => 'datetime',
        'waktu_bayar_lunas' => 'datetime',
        'tanggal_mulai' => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
