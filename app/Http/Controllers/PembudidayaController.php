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
            'address' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pembudidaya->name = $request->name;
        $pembudidaya->address = $request->address;
        $pembudidaya->nomor_telepon = $request->nomor_telepon;
        $pembudidaya->deskripsi = $request->deskripsi;

        if ($request->hasFile('foto_profile')) {
            // Hapus foto lama jika ada
            if ($pembudidaya->foto_profil) {
                Storage::delete('public/' . $pembudidaya->foto_profil);
            }

            $path = $request->file('foto_profile')->store('profile_photos', 'public');
            $pembudidaya->foto_profil = $path;
        }

        $pembudidaya->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
