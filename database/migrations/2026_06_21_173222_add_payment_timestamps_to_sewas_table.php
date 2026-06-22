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
        Schema::table('sewas', function (Blueprint $table) {
            $table->timestamp('waktu_bayar_dp')->nullable()->after('status_pembayaran');
            $table->timestamp('waktu_bayar_lunas')->nullable()->after('waktu_bayar_dp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sewas', function (Blueprint $table) {
            $table->dropColumn(['waktu_bayar_dp', 'waktu_bayar_lunas']);
        });
    }
};
