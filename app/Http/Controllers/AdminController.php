<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Sewa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function dashboard()
    {
        $barangs = Barang::all();
        
        $totalBarang = $barangs->count();
        $totalKamera = $barangs->where('kategori', 'Kamera')->count();
        $totalCamping = $barangs->where('kategori', 'Alat Camping')->count();
        $totalPaket = $barangs->where('kategori', 'Paket')->count();
        $totalPelanggan = User::where('role', 'pelanggan')->count();
        $totalPendapatan = Sewa::sum('total_biaya');

        return view('admin.dashboard_admin', compact(
            'totalBarang', 'totalKamera', 'totalCamping', 'totalPaket', 
            'totalPelanggan', 'totalPendapatan', 'barangs'
        ));
    }

    /**
     * Simpan Barang Baru
     */
    public function storeBarang(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string',
            'harga_sewa' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nama_foto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('images/barang'), $nama_foto);
            $validated['foto'] = 'images/barang/' . $nama_foto;
        }

        Barang::create($validated);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Update Data Barang
     */
    public function updateBarang(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string',
            'harga_sewa' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($barang->foto && File::exists(public_path($barang->foto))) {
                File::delete(public_path($barang->foto));
            }
            
            $foto = $request->file('foto');
            $nama_foto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('images/barang'), $nama_foto);
            $validated['foto'] = 'images/barang/' . $nama_foto;
        }

        $barang->update($validated);

        return redirect()->back()->with('success', 'Barang berhasil diupdate!');
    }

    /**
     * Hapus Barang
     */
    public function destroyBarang($id)
    {
        $barang = Barang::findOrFail($id);
        
        // Hapus foto jika ada
        if ($barang->foto && File::exists(public_path($barang->foto))) {
            File::delete(public_path($barang->foto));
        }
        
        $barang->delete();

        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }

    /**
     * Data Pelanggan
     */
    public function dataPelanggan()
    {
        $pelanggans = User::where('role', 'pelanggan')
            ->withSum('sewas as total_bayar', 'total_biaya')
            ->withSum('sewas as total_denda', 'denda')
            ->get()
            ->map(function($user) {
                $user->booking_aktif = Sewa::where('user_id', $user->id)
                    ->whereIn('status_sewa', ['Booking', 'Aktif'])
                    ->exists();
                return $user;
            });

        return view('admin.data_pelanggan', compact('pelanggans'));
    }

    /**
     * Riwayat Sewa (Admin)
     */
    public function riwayatSewa()
    {
        $riwayatSewa = Sewa::with(['user', 'barang'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.riwayat_sewa_pelanggan', compact('riwayatSewa'));
    }

    /**
     * Konfirmasi Pembayaran DP
     */
    public function konfirmasiDP($id)
    {
        $sewa = Sewa::findOrFail($id);
        $sewa->update(['status_pembayaran' => 'DP Dibayar']);

        return redirect()->back()->with('success', 'Pembayaran DP berhasil dikonfirmasi!');
    }

    /**
     * Mulai Sewa (Barang Diambil)
     */
    public function mulaiSewa($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $sewa = Sewa::findOrFail($id);
                
                // Cek stok sebelum mulai
                if ($sewa->barang->stok < $sewa->jumlah) {
                    throw new \Exception('Stok barang tidak mencukupi untuk memulai sewa!');
                }

                $sewa->update(['status_sewa' => 'Aktif']);
                
                // Kurangi stok barang
                $sewa->barang->decrement('stok', $sewa->jumlah);
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Sewa telah dimulai, barang telah diambil!');
    }

    /**
     * Selesai Sewa (Barang Kembali)
     */
    public function selesaiSewa(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $sewa = Sewa::findOrFail($id);
            
            // Hitung denda jika ada (input manual dari admin atau otomatis)
            $denda = $request->denda ?? 0;

            $sewa->update([
                'status_sewa' => 'Selesai',
                'status_pembayaran' => 'Lunas',
                'sisa_bayar' => 0,
                'denda' => $denda
            ]);

            // Tambahkan kembali stok barang
            $sewa->barang->increment('stok', $sewa->jumlah);
        });

        return redirect()->back()->with('success', 'Sewa selesai dan pembayaran telah lunas!');
    }
}
