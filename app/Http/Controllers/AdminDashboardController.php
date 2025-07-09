<?php

namespace App\Http\Controllers;

use App\Models\DokumenPembudidaya;
use App\Models\Produk;
use App\Models\User;
use App\Models\Pembudidaya;
use Illuminate\Http\Request;
use App\Notifications\NotifikasiPembudidaya;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Jumlah total
        $jumlahPengguna = User::count();
        $jumlahPembudidaya = Pembudidaya::count();
        $jumlahKomoditas = Produk::count();

        // Jumlah yang menunggu persetujuan
        $jumlahDokumenMenunggu = DokumenPembudidaya::where('status', 'menunggu')->count();
        $jumlahProdukMenunggu = Produk::whereNull('is_approved')->count();

        // List pembudidaya menunggu persetujuan (urut berdasarkan dokumen terbaru)
        $pembudidayaMenunggu = Pembudidaya::whereHas('dokumenPembudidaya', function ($query) {
                $query->where('status', 'menunggu');
            })
            ->with(['dokumenPembudidaya' => function ($query) {
                $query->latest(); // ambil dokumen terbaru
            }])
            ->orderByDesc(
                DokumenPembudidaya::select('created_at')
                    ->whereColumn('pembudidaya_id', 'pembudidaya.id')
                    ->latest()
                    ->limit(1)
            )
            ->paginate(5, ['*'], 'pembudidaya_page');

        // List produk menunggu persetujuan (urutkan terbaru)
        $produkMenunggu = Produk::whereNull('is_approved')
            ->with('pembudidaya')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'produk_page');

        return view('admin.dashboard', compact(
            'jumlahPengguna',
            'jumlahPembudidaya',
            'jumlahKomoditas',
            'jumlahDokumenMenunggu',
            'jumlahProdukMenunggu',
            'pembudidayaMenunggu',
            'produkMenunggu'
        ));
    }

    public function approve($id)
    {
        $dokumen = DokumenPembudidaya::findOrFail($id);

        if ($dokumen->status === 'menunggu') {
            $dokumen->status = 'disetujui';
            $dokumen->save();

            $pembudidaya = $dokumen->pembudidaya;

            // Kirim notifikasi database
            if ($pembudidaya) {
                $pembudidaya->notify(new NotifikasiPembudidaya(
                    'Dokumen Disetujui',
                    'Selamat! Dokumen usaha Anda telah disetujui oleh admin. Anda kini dapat mengunggah produk.'
                ));
            }

            return redirect()->back()->with('success', 'Dokumen berhasil disetujui.');
        }

        return redirect()->back()->with('error', 'Dokumen sudah diproses sebelumnya.');
    }

    public function reject($id)
    {
        $dokumen = DokumenPembudidaya::findOrFail($id);

        if ($dokumen->status === 'menunggu') {
            $dokumen->status = 'ditolak';
            $dokumen->save();

            $pembudidaya = $dokumen->pembudidaya;

            // Kirim notifikasi database
            if ($pembudidaya) {
                $pembudidaya->notify(new NotifikasiPembudidaya(
                    'Dokumen Ditolak',
                    'Mohon maaf, dokumen usaha Anda ditolak oleh admin. Silakan unggah ulang dokumen dengan data yang valid.'
                ));
            }

            return redirect()->back()->with('success', 'Dokumen berhasil ditolak.');
        }

        return redirect()->back()->with('error', 'Dokumen sudah diproses sebelumnya.');
    }
}
