<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembudidaya;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PembudidayaController extends Controller
{
    public function edit()
    {
        $pembudidaya = Auth::guard('pembudidaya')->user();
        return view('pembudidaya.edit', compact('pembudidaya'));
    }

    public function update(Request $request)
    {
        $pembudidaya = Auth::guard('pembudidaya')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update data di tabel pembudidaya
        $pembudidaya->name = $request->name;
        $pembudidaya->save();

        // Pastikan relasi profil ada
        $profil = $pembudidaya->profil ?? new \App\Models\ProfilPembudidaya();
        $profil->pembudidaya_id = $pembudidaya->id;
        $profil->alamat = $request->alamat;
        $profil->nomor_telepon = $request->nomor_telepon;
        $profil->deskripsi = $request->deskripsi;

        if ($request->hasFile('foto_profile')) {
            // Hapus foto lama jika ada
            if ($profil->foto_profil) {
                \Storage::delete('public/' . $profil->foto_profil);
            }

            $path = $request->file('foto_profile')->store('profile_photos', 'public');
            $profil->foto_profil = $path;
        }

        $profil->save();

        return redirect()->route('pembudidaya.profil', $pembudidaya->id)->with('success', 'Profil berhasil diperbarui.');
    }
}
