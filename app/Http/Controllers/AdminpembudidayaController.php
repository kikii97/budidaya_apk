<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembudidaya;
use Illuminate\Support\Facades\Storage;
use App\Models\DokumenPembudidaya;
use App\Notifications\NotifikasiPembudidaya;

class AdminPembudidayaController extends Controller
{
    public function index()
    {
        $pembudidaya = Pembudidaya::with('dokumenPembudidaya')
            ->leftJoin('dokumen_pembudidaya', 'pembudidaya.id', '=', 'dokumen_pembudidaya.pembudidaya_id')
            ->orderByRaw("CASE 
                WHEN dokumen_pembudidaya.status = 'menunggu' THEN 0 
                WHEN dokumen_pembudidaya.status = 'disetujui' THEN 1 
                WHEN dokumen_pembudidaya.status = 'ditolak' THEN 2 
                ELSE 3 END")
            ->orderBy('pembudidaya.created_at', 'desc')
            ->select('pembudidaya.*') // penting: supaya field-nya tidak bentrok
            ->paginate(10);

        return view('admin.pembudidaya.index', compact('pembudidaya'));
    }

    public function create()
    {
        return view('admin.pembudidaya.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:pembudidaya,email',
            'password' => 'required|string|min:6|confirmed',
            'surat_usaha.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto_usaha.*' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        // Simpan data user pembudidaya
        $pembudidaya = new Pembudidaya();
        $pembudidaya->name = $request->name;
        $pembudidaya->email = $request->email;
        $pembudidaya->password = bcrypt($request->password);
        $pembudidaya->save();

        // Upload file surat usaha
        $suratPaths = [];
        if ($request->hasFile('surat_usaha')) {
            foreach ($request->file('surat_usaha') as $file) {
                $suratPaths[] = $file->store('dokumen/surat_usaha', 'public');
            }
        }

        // Upload file foto usaha
        $fotoPaths = [];
        if ($request->hasFile('foto_usaha')) {
            foreach ($request->file('foto_usaha') as $file) {
                $fotoPaths[] = $file->store('dokumen/foto_usaha', 'public');
            }
        }

        // Simpan ke tabel dokumen_pembudidaya
        DokumenPembudidaya::create([
            'pembudidaya_id' => $pembudidaya->id,
            'surat_usaha_path' => json_encode($suratPaths),
            'foto_usaha_path' => json_encode($fotoPaths),
            'keterangan' => $request->keterangan,
            'status' => 'menunggu',
        ]);

        return redirect()->route('admin.pembudidaya.index')->with('success', 'Pembudidaya dan dokumen berhasil ditambahkan.');
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

    public function show($id)
    {
        $dokumen = DokumenPembudidaya::with('pembudidaya')->findOrFail($id);
        return view('admin.pembudidaya.detail', compact('dokumen'));
    }

    public function destroy($id)
    {
        $pembudidaya = Pembudidaya::with('dokumenPembudidaya')->findOrFail($id);

        if ($pembudidaya->dokumenPembudidaya && in_array($pembudidaya->dokumenPembudidaya->status, ['disetujui', 'ditolak'])) {
            // Hapus file dari storage
            if ($pembudidaya->dokumenPembudidaya) {
                Storage::disk('public')->delete([
                    $pembudidaya->dokumenPembudidaya->surat_usaha_path,
                    $pembudidaya->dokumenPembudidaya->foto_usaha_path
                ]);

                $pembudidaya->dokumenPembudidaya->delete();
            }

            // Hapus pembudidaya
            $pembudidaya->delete();

            return redirect()->route('admin.pembudidaya.index')->with('success', 'Pembudidaya berhasil dihapus.');
        }

        return redirect()->route('admin.pembudidaya.index')->with('error', 'Hanya pembudidaya yang dokumennya sudah diproses bisa dihapus.');
    }

}
