<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembudidaya;
use Illuminate\Support\Facades\Storage;
use App\Models\DokumenPembudidaya;
use App\Notifications\NotifikasiPembudidaya;
use App\Models\ProfilPembudidaya;

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
            ->select('pembudidaya.*')
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
            'alamat' => 'nullable|string|max:1000',
            'nomor_telepon' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string|max:1000',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'surat_usaha.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto_usaha.*' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        // Simpan data pembudidaya
        $pembudidaya = new Pembudidaya();
        $pembudidaya->name = $request->name;
        $pembudidaya->email = $request->email;
        $pembudidaya->password = bcrypt($request->password);
        $pembudidaya->save();

        // Simpan data profil pembudidaya
        $profil = new ProfilPembudidaya();
        $profil->pembudidaya_id = $pembudidaya->id;
        $profil->alamat = $request->alamat;
        $profil->nomor_telepon = $request->nomor_telepon;
        $profil->deskripsi = $request->deskripsi;
        if ($request->hasFile('foto_profil')) {
            $profil->foto_profil = $request->file('foto_profil')->store('profil', 'public');
        }
        $profil->save();

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

        // Simpan dokumen usaha
        DokumenPembudidaya::create([
            'pembudidaya_id' => $pembudidaya->id,
            'surat_usaha_path' => json_encode($suratPaths),
            'foto_usaha_path' => json_encode($fotoPaths),
            'keterangan' => $request->keterangan,
            'status' => 'menunggu',
        ]);

        return redirect()->route('admin.pembudidaya.index')->with('success', 'Pembudidaya dan dokumen berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pembudidaya = Pembudidaya::with(['dokumenPembudidaya', 'profil'])->findOrFail($id);

        // Ensure dokumenPembudidaya is available, default to empty if null
        $pembudidaya->dokumenPembudidaya = $pembudidaya->dokumenPembudidaya ?? (object) [
            'surat_usaha_path' => '[]',
            'foto_usaha_path' => '[]',
            'keterangan' => '',
            'status' => 'menunggu',
        ];

        // Debug log for paths
        \Log::info('Edit - Pembudidaya ID: ' . $id . ', Surat Usaha Path: ' . $pembudidaya->dokumenPembudidaya->surat_usaha_path . ', Foto Usaha Path: ' . $pembudidaya->dokumenPembudidaya->foto_usaha_path);

        return view('admin.pembudidaya.edit', compact('pembudidaya'));
    }

    public function update(Request $request, $id)
    {
        $pembudidaya = Pembudidaya::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:pembudidaya,email,' . $pembudidaya->id,
            'password' => 'nullable|string|min:6|confirmed',
            'alamat' => 'nullable|string|max:1000',
            'nomor_telepon' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string|max:1000',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'surat_usaha.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto_usaha.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $pembudidaya->name = $request->name;
        $pembudidaya->email = $request->email;
        if ($request->filled('password')) {
            $pembudidaya->password = bcrypt($request->password);
        }
        $pembudidaya->save();

        $profil = ProfilPembudidaya::firstOrNew(['pembudidaya_id' => $pembudidaya->id]);
        $profil->alamat = $request->alamat;
        $profil->nomor_telepon = $request->nomor_telepon;
        $profil->deskripsi = $request->deskripsi;
        if ($request->hasFile('foto_profil')) {
            if ($profil->foto_profil) {
                Storage::disk('public')->delete($profil->foto_profil);
            }
            $profil->foto_profil = $request->file('foto_profil')->store('profil', 'public');
        }
        $profil->save();

        // Handle dokumenPembudidaya
        $dokumen = $pembudidaya->dokumenPembudidaya ?? new DokumenPembudidaya(['pembudidaya_id' => $pembudidaya->id]);

        $suratPaths = $dokumen->surat_usaha_path ? json_decode($dokumen->surat_usaha_path, true) : [];
        $fotoPaths = $dokumen->foto_usaha_path ? json_decode($dokumen->foto_usaha_path, true) : [];

        // Handle file removals
        if ($request->has('remove_files')) {
            foreach ((array) $request->remove_files as $path) {
                $index = array_search($path, $suratPaths);
                if ($index !== false) {
                    Storage::disk('public')->delete($path);
                    unset($suratPaths[$index]);
                    $suratPaths = array_values($suratPaths);
                }
                $index = array_search($path, $fotoPaths);
                if ($index !== false) {
                    Storage::disk('public')->delete($path);
                    unset($fotoPaths[$index]);
                    $fotoPaths = array_values($fotoPaths);
                }
            }
        }

        // Handle new file uploads
        if ($request->hasFile('surat_usaha')) {
            foreach ($request->file('surat_usaha') as $file) {
                $suratPaths[] = $file->store('dokumen/surat_usaha', 'public');
            }
        }

        if ($request->hasFile('foto_usaha')) {
            foreach ($request->file('foto_usaha') as $file) {
                $fotoPaths[] = $file->store('dokumen/foto_usaha', 'public');
            }
        }

        // Ensure paths are saved consistently
        $dokumen->surat_usaha_path = json_encode(array_filter($suratPaths));
        $dokumen->foto_usaha_path = json_encode(array_filter($fotoPaths));
        $dokumen->keterangan = $request->keterangan;
        $dokumen->status = $dokumen->status ?? 'menunggu';
        $dokumen->save();

        // Debug log for updated paths
        \Log::info('Update - Pembudidaya ID: ' . $id . ', Surat Usaha Path: ' . $dokumen->surat_usaha_path . ', Foto Usaha Path: ' . $dokumen->foto_usaha_path);

        return redirect()->route('admin.pembudidaya.index')->with('success', 'Pembudidaya dan dokumen berhasil diperbarui.');
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
                $suratPaths = $pembudidaya->dokumenPembudidaya->surat_usaha_path ? json_decode($pembudidaya->dokumenPembudidaya->surat_usaha_path, true) : [];
                $fotoPaths = $pembudidaya->dokumenPembudidaya->foto_usaha_path ? json_decode($pembudidaya->dokumenPembudidaya->foto_usaha_path, true) : [];

                // Hapus semua file surat usaha
                foreach ($suratPaths as $path) {
                    Storage::disk('public')->delete($path);
                }

                // Hapus semua file foto usaha
                foreach ($fotoPaths as $path) {
                    Storage::disk('public')->delete($path);
                }

                $pembudidaya->dokumenPembudidaya->delete();
            }

            // Hapus pembudidaya
            $pembudidaya->delete();

            return redirect()->route('admin.pembudidaya.index')->with('success', 'Pembudidaya berhasil dihapus.');
        }

        return redirect()->route('admin.pembudidaya.index')->with('error', 'Hanya pembudidaya yang dokumennya sudah diproses bisa dihapus.');
    }
}