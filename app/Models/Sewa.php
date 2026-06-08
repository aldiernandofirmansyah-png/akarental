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
        'tanggal_mulai',
        'tanggal_kembali',
        'jumlah',
        'total_biaya',
        'dp_amount',
        'sisa_bayar',
        'denda',
        'status_pembayaran',
        'status_sewa',
        'catatan',
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
