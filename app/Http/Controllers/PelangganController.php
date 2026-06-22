<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Sewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    /**
     * Dashboard Pelanggan
     */
    public function dashboard()
    {
        $barangsPelanggan = Barang::where('stok', '>', 0)->get();
        return view('pelanggan.dashboard_pelanggan', compact('barangsPelanggan'));
    }

    /**
     * Simpan Booking Baru ke Database
     */
    public function storeBooking(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_mulai' => 'required|date|after:today',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_mulai',
            'jumlah' => 'required|integer|min:1',
            'no_telp' => 'required|string|max:20',
        ]);

        return DB::transaction(function () use ($request) {
            $user = Auth::user();
            
            // Update no_telp user jika berbeda
            if ($user->no_telp !== $request->no_telp) {
                $user->update(['no_telp' => $request->no_telp]);
            }

            $barang = Barang::findOrFail($request->barang_id);
            
            // Hitung durasi hari
            $mulai = new \DateTime($request->tanggal_mulai);
            $kembali = new \DateTime($request->tanggal_kembali);
            $diff = $mulai->diff($kembali)->days;
            $hari = $diff == 0 ? 1 : $diff;

            $total_harga = $hari * $barang->harga_sewa * $request->jumlah;
            $dp_amount = $total_harga * 0.3; // DP 30%
            $sisa_bayar = $total_harga - $dp_amount;

            // Simpan ke database
            $sewa = Sewa::create([
                'user_id' => $user->id,
                'barang_id' => $request->barang_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_kembali' => $request->tanggal_kembali,
                'jumlah' => $request->jumlah,
                'total_biaya' => $total_harga,
                'dp_amount' => $dp_amount,
                'sisa_bayar' => $sisa_bayar,
                'status_pembayaran' => 'Menunggu DP',
                'status_sewa' => 'Booking',
            ]);

            return response()->json([
                'success' => true,
                'booking_id' => $sewa->id,
                'total_biaya' => $total_harga,
                'dp_amount' => $dp_amount,
                'sisa_bayar' => $sisa_bayar
            ]);
        });
    }

    /**
     * Riwayat Sewa Pelanggan
     */
    public function riwayatSewa()
    {
        $riwayatSaya = Sewa::with('barang')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('pelanggan.riwayat_sewa', compact('riwayatSaya'));
    }

    /**
     * Halaman Perpanjangan
     */
    public function perpanjangan($id)
    {
        $sewa = Sewa::with('barang')->where('user_id', Auth::id())->findOrFail($id);
        $dendaPerHari = 20000;

        return view('pelanggan.perpanjangan', compact('sewa', 'dendaPerHari'));
    }

    /**
     * Proses Simpan Perpanjangan
     */
    public function storePerpanjangan(Request $request, $id)
    {
        $sewa = Sewa::with('barang')->where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'tanggal_kembali_baru' => 'required|date|after:' . $sewa->tanggal_kembali,
        ]);

        DB::transaction(function () use ($request, $sewa) {
            // Hitung selisih hari tambahan
            $lama = new \DateTime($sewa->tanggal_kembali);
            $baru = new \DateTime($request->tanggal_kembali_baru);
            $hariTambahan = $lama->diff($baru)->days;

            $biayaTambahan = $hariTambahan * $sewa->barang->harga_sewa;

            // Update data sewa
            $sewa->update([
                'tanggal_kembali' => $request->tanggal_kembali_baru,
                'total_biaya' => $sewa->total_biaya + $biayaTambahan,
                'sisa_bayar' => $sewa->sisa_bayar + $biayaTambahan,
            ]);
        });

        return redirect()->route('pelanggan.riwayat_sewa')->with('success', 'Sewa berhasil diperpanjang!');
    }
}
