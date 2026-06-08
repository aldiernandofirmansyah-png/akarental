<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sewas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->date('tanggal_mulai');
            $table->date('tanggal_kembali');
            $table->integer('jumlah')->default(1);
            $table->integer('total_biaya');
            $table->integer('dp_amount')->default(0);
            $table->integer('sisa_bayar')->default(0);
            $table->integer('denda')->default(0);
            $table->string('status_pembayaran')->default('Menunggu DP'); // Menunggu DP, DP Dibayar, Lunas
            $table->string('status_sewa')->default('Booking'); // Booking, Aktif, Selesai, Dibatalkan
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewas');
    }
};
