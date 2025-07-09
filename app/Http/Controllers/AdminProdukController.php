<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Support\Facades\Storage;
use App\Notifications\NotifikasiPembudidaya;

class AdminProdukController extends Controller
{
    // Tampilkan daftar produk
    public function index()
    {
        $produk = Produk::with('pembudidaya')
            ->orderByRaw("CASE 
                WHEN is_approved IS NULL THEN 0 
                WHEN is_approved = 0 THEN 1 
                WHEN is_approved = 1 THEN 2 
                ELSE 3 END")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.produk.index', compact('produk'));
    }

    public function show($id)
    {
        $produk = Produk::with('pembudidaya')->findOrFail($id);
        return view('admin.produk.detail', compact('produk'));
    }

    public function approve($id)
    {
        $produk = Produk::with('pembudidaya')->findOrFail($id);

        if (!is_null($produk->is_approved)) {
            return redirect()->back()->with('error', 'Produk sudah memiliki status persetujuan.');
        }

        $produk->is_approved = true;
        $produk->save();

        $pembudidaya = $produk->pembudidaya;

        if ($pembudidaya) {
            $pembudidaya->notify(new NotifikasiPembudidaya(
                'Produk Disetujui',
                'Produk Anda telah disetujui dan akan tampil di halaman pengguna.',
                [
                    'jenis_produk' => $produk->jenis_komoditas . ' - ' . $produk->jenis_spesifik_komoditas,
                    'tanggal_disetujui' => now()->format('Y-m-d'),
                    'tanggal_diunggah' => $produk->created_at->format('Y-m-d')
                ]
            ));
        }

        return redirect()->back()->with('success', 'Produk berhasil disetujui dan akan tampil di halaman pembudidaya & pengguna.');
    }
            
    public function reject($id)
    {
        $produk = Produk::with('pembudidaya')->findOrFail($id);

        if (!is_null($produk->is_approved)) {
            return redirect()->back()->with('error', 'Produk sudah memiliki status persetujuan.');
        }

        $produk->is_approved = false;
        $produk->save();

        $pembudidaya = $produk->pembudidaya;

        if ($pembudidaya) {
            $pembudidaya->notify(new NotifikasiPembudidaya(
                'Produk Ditolak',
                'Mohon maaf, produk Anda ditolak oleh admin. Silakan periksa kembali data produk.',
                [
                    'jenis_produk' => $produk->jenis_komoditas . ' - ' . $produk->jenis_spesifik_komoditas,
                    'tanggal_ditolak' => now()->format('Y-m-d'),
                    'tanggal_diunggah' => $produk->created_at->format('Y-m-d')
                ]
            ));
        }

        return redirect()->back()->with('success', 'Produk berhasil ditolak.');
    }
    
    // Hapus produk
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus gambar dari storage
        if ($produk->gambar) {
            $gambarList = json_decode($produk->gambar, true);
            foreach ($gambarList as $gambar) {
                Storage::disk('public')->delete("produk/{$gambar}");
            }
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
