<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function dashboard()
    {
        $barangs = \App\Models\Barang::all();
        
        $totalBarang = $barangs->count();
        $totalKamera = $barangs->where('kategori', 'Kamera')->count();
        $totalCamping = $barangs->where('kategori', 'Alat Camping')->count();
        $totalPaket = $barangs->where('kategori', 'Paket')->count();
        $totalPelanggan = \App\Models\User::where('role', 'pelanggan')->count();
        $totalPendapatan = \App\Models\Sewa::where('status_pembayaran', 'Lunas')->sum('total_biaya');

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
        $request->validate([
            'nama_barang' => 'required',
            'kategori' => 'required',
            'harga_sewa' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nama_foto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('images/barang'), $nama_foto);
            $data['foto'] = 'images/barang/' . $nama_foto;
        }

        \App\Models\Barang::create($data);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Update Data Barang
     */
    public function updateBarang(Request $request, $id)
    {
        $barang = \App\Models\Barang::findOrFail($id);
        
        $request->validate([
            'nama_barang' => 'required',
            'kategori' => 'required',
            'harga_sewa' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($barang->foto && file_exists(public_path($barang->foto))) {
                unlink(public_path($barang->foto));
            }
            
            $foto = $request->file('foto');
            $nama_foto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('images/barang'), $nama_foto);
            $data['foto'] = 'images/barang/' . $nama_foto;
        }

        $barang->update($data);

        return redirect()->back()->with('success', 'Barang berhasil diupdate!');
    }

    /**
     * Hapus Barang
     */
    public function destroyBarang($id)
    {
        $barang = \App\Models\Barang::findOrFail($id);
        
        // Hapus foto jika ada
        if ($barang->foto && file_exists(public_path($barang->foto))) {
            unlink(public_path($barang->foto));
        }
        
        $barang->delete();

        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }

    /**
     * Data Pelanggan
     */
    public function dataPelanggan()
    {
        $pelanggans = \App\Models\User::where('role', 'pelanggan')
            ->withSum(['sewas as total_bayar' => function($query) {
                $query->where('status_pembayaran', 'Lunas');
            }], 'total_biaya')
            ->withSum('sewas as denda', 'denda')
            ->get()
            ->map(function($user) {
                $user->booking_aktif = \App\Models\Sewa::where('user_id', $user->id)
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
        $riwayatSewa = \App\Models\Sewa::with(['user', 'barang'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.riwayat_sewa_pelanggan', compact('riwayatSewa'));
    }

    /**
     * Konfirmasi Pembayaran DP
     */
    public function konfirmasiDP($id)
    {
        $sewa = \App\Models\Sewa::findOrFail($id);
        $sewa->update(['status_pembayaran' => 'DP Dibayar']);

        return redirect()->back()->with('success', 'Pembayaran DP berhasil dikonfirmasi!');
    }

    /**
     * Mulai Sewa (Barang Diambil)
     */
    public function mulaiSewa($id)
    {
        $sewa = \App\Models\Sewa::findOrFail($id);
        $sewa->update(['status_sewa' => 'Aktif']);

        return redirect()->back()->with('success', 'Sewa telah dimulai, barang telah diambil!');
    }

    /**
     * Selesai Sewa (Barang Kembali)
     */
    public function selesaiSewa(Request $request, $id)
    {
        $sewa = \App\Models\Sewa::findOrFail($id);
        
        // Hitung denda jika ada (input manual dari admin atau otomatis)
        $denda = $request->denda ?? 0;

        $sewa->update([
            'status_sewa' => 'Selesai',
            'status_pembayaran' => 'Lunas',
            'sisa_bayar' => 0,
            'denda' => $denda
        ]);

        return redirect()->back()->with('success', 'Sewa selesai dan pembayaran telah lunas!');
    }
}