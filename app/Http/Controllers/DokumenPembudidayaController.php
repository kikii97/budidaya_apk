<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\DokumenPembudidaya;

class DokumenPembudidayaController extends Controller
{
    // Tampilkan semua dokumen milik pembudidaya yang sedang login
    public function index()
    {
        $pembudidaya = Auth::guard('pembudidaya')->user();
        $dokumen = DokumenPembudidaya::where('pembudidaya_id', $pembudidaya->id)->get();

        return view('dokumen.index', compact('dokumen'));
    }

    // Form untuk unggah dokumen baru
    public function create()
    {
        return view('pembudidaya.unggah_dokumen');
    }

    // Simpan dokumen ke database dan storage
    public function store(Request $request)
    {
        $request->validate([
            'surat_usaha.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto_usaha.*' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        $suratPaths = [];
        $fotoPaths = [];

        if ($request->hasFile('surat_usaha')) {
            foreach ($request->file('surat_usaha') as $surat) {
                $suratPaths[] = $surat->store('dokumen/surat_usaha', 'public');
            }
        }

        if ($request->hasFile('foto_usaha')) {
            foreach ($request->file('foto_usaha') as $foto) {
                $fotoPaths[] = $foto->store('dokumen/foto_usaha', 'public');
            }
        }

        DokumenPembudidaya::create([
            'pembudidaya_id' => Auth::guard('pembudidaya')->id(),
            'surat_usaha_path' => json_encode($suratPaths),
            'foto_usaha_path' => json_encode($fotoPaths),
            'keterangan' => $request->keterangan,
            'status' => 'menunggu',
        ]);

        return redirect()->route('usaha.detail', Auth::guard('pembudidaya')->id())->with('success', 'Dokumen berhasil diunggah dan akan diperiksa oleh admin. Mohon menunggu persetujuan sebelum dapat mengunggah komoditas.');
    }

    // Hapus dokumen milik sendiri (tidak digunakan jika tidak ada fitur hapus)
    public function destroy($id)
    {
        $dokumen = DokumenPembudidaya::findOrFail($id);

        if ($dokumen->pembudidaya_id !== Auth::guard('pembudidaya')->id()) {
            abort(403, 'Anda tidak memiliki akses');
        }

        Storage::disk('public')->delete($dokumen->file_path);
        $dokumen->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    // Tampilkan detail dokumen (opsional)
    public function show($id)
    {
        $dokumen = DokumenPembudidaya::findOrFail($id);

        if ($dokumen->pembudidaya_id !== Auth::guard('pembudidaya')->id()) {
            abort(403);
        }

        return view('dokumen.show', compact('dokumen'));
    }
}
