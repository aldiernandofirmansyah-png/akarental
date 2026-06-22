<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Sewa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Controller untuk mengelola fitur-fitur admin.
 */
class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan statistik dan daftar sewa aktif.
     */
    public function dashboard()
    {
        $barangs = Barang::all();
        
        // Menghitung statistik untuk ringkasan dashboard
        $totalBarang = $barangs->count();
        $totalKamera = $barangs->where('kategori', 'Kamera')->count();
        $totalCamping = $barangs->where('kategori', 'Alat Camping')->count();
        $totalPaket = $barangs->where('kategori', 'Paket')->count();
        $totalPelanggan = User::where('role', 'pelanggan')->count();
        $totalPendapatan = Sewa::where('status_sewa', 'Selesai')->sum('total_biaya');
        
        // Mengambil data sewa yang sedang aktif untuk ditampilkan
        $sewaAktif = Sewa::with(['user', 'barang'])
            ->whereIn('status_sewa', ['Aktif'])
            ->orderBy('tanggal_kembali', 'asc')
            ->get();

        return view('admin.dashboard_admin', compact(
            'totalBarang', 'totalKamera', 'totalCamping', 'totalPaket', 
            'totalPelanggan', 'totalPendapatan', 'sewaAktif', 'barangs'
        ));
    }

    /**
     * Menampilkan halaman manajemen barang.
     */
    public function manajemenBarang()
    {
        $barangs = Barang::all();
        return view('admin.manajemen_barang', compact('barangs'));
    }

    /**
     * Menyimpan barang baru ke database.
     */
    public function storeBarang(Request $request)
    {
        // Validasi input data barang
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer',
            'harga_sewa' => 'required|numeric',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
            'harga_sewa' => $request->harga_sewa,
        ];


        // Memproses pengunggahan file foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('images/barang'), $namaFoto);
            $data['foto'] = 'images/barang/' . $namaFoto;
        }

        Barang::create($data);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Memperbarui data barang yang ada.
     */
    public function updateBarang(Request $request, $id)
    {
        // Validasi input pembaruan data
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer',
            'harga_sewa' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $barang = Barang::findOrFail($id);

        $data = [
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
            'harga_sewa' => $request->harga_sewa,
        ];

        // Memproses pengunggahan foto baru dan menghapus foto lama
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($barang->foto && File::exists(public_path($barang->foto))) {
                File::delete(public_path($barang->foto));
            }

            // Simpan foto baru
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('images/barang'), $namaFoto);
            $data['foto'] = 'images/barang/' . $namaFoto;
        }

        $barang->update($data);

        return redirect()->back()->with('success', 'Barang berhasil diperbarui!');
    }

    /**
     * Menampilkan daftar booking yang perlu dikonfirmasi.
     */
    public function konfirmasiBooking()
    {
        $bookings = Sewa::with(['user', 'barang'])
            ->whereIn('status_sewa', ['Booking', 'Aktif'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.konfirmasi_booking', compact('bookings'));
    }

    /**
     * Menampilkan riwayat sewa yang sudah selesai.
     */
    public function riwayatSewaFinal()
    {
        $riwayat = Sewa::with(['user', 'barang'])
            ->where('status_sewa', 'Selesai')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.riwayat_sewa', compact('riwayat'));
    }

    /**
     * Menghapus data barang dan fotonya.
     */
    public function destroyBarang($id)
    {
        $barang = Barang::findOrFail($id);
        
        // Hapus foto dari penyimpanan
        if ($barang->foto && File::exists(public_path($barang->foto))) {
            File::delete(public_path($barang->foto));
        }
        
        $barang->delete();

        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }

    /**
     * Mengonfirmasi pembayaran DP dan mencatat kode barang fisik.
     */
    public function konfirmasiDP(Request $request, $id)
    {
        $request->validate([
            'kode_barang_fisik' => 'required|string|max:50',
        ]);

        $sewa = Sewa::findOrFail($id);
        $sewa->update([
            'status_pembayaran' => 'DP Dibayar',
            'waktu_bayar_dp' => now(),
            'kode_barang_fisik' => $request->kode_barang_fisik
        ]);

        return redirect()->back()->with('success', 'Pembayaran DP berhasil dikonfirmasi dan kode barang dicatat!');
    }

    /**
     * Mengubah status sewa menjadi Aktif (barang diambil).
     */
    public function mulaiSewa($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $sewa = Sewa::findOrFail($id);
                
                // Pengecekan stok
                if ($sewa->barang->stok < $sewa->jumlah) {
                    throw new \Exception('Stok barang tidak mencukupi untuk memulai sewa!');
                }

                $sewa->update([
                    'status_sewa' => 'Aktif',
                    'status_pembayaran' => 'Lunas',
                    'waktu_bayar_lunas' => now(),
                    'sisa_bayar' => 0
                ]);
                
                // Kurangi stok barang
                $sewa->barang->decrement('stok', $sewa->jumlah);
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Sewa dimulai: Pembayaran dilunasi dan jaminan KTP diterima!');
    }

    /**
     * Mengubah status sewa menjadi Selesai (barang dikembalikan).
     */
    public function selesaiSewa(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $sewa = Sewa::findOrFail($id);
            
            // Hitung denda otomatis
            $denda = 0;
            $hariIni = new \DateTime();
            $tanggalKembali = new \DateTime($sewa->tanggal_kembali);

            if ($hariIni > $tanggalKembali) {
                $selisih = $hariIni->diff($tanggalKembali)->days;
                $denda = $selisih * 20000;
            }

            $sewa->update([
                'status_sewa' => 'Selesai',
                'denda' => $denda
            ]);

            // Tambahkan kembali stok barang
            $sewa->barang->increment('stok', $sewa->jumlah);
        });

        return redirect()->back()->with('success', 'Sewa selesai! Denda telah dihitung otomatis jika ada keterlambatan.');
    }
}
