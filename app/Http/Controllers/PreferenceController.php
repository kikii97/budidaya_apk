<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    /**
     * Tampilkan form pengisian preferensi jika belum diisi.
     */
    public function create()
    {
        $user = Auth::user();

        // Cek apakah preferensi sudah diisi
        if (
            $user->komoditas && $user->harga_min !== null && $user->harga_max !== null &&
            $user->kecamatan && $user->prediksi_panen && $user->kapasitas_produksi !== null
        ) {
            return redirect()->route('home')->with('info', 'Anda sudah mengisi preferensi.');
        }

        // Daftar kecamatan (bisa diganti ambil dari DB jika tersedia)
        $kecamatanList = [
            'Anjatan', 'Arahan', 'Balongan', 'Bangodua', 'Bongas',
            'Cantigi', 'Cikedung', 'Gabuswetan', 'Gantar', 'Haurgeulis',
            'Indramayu', 'Jatibarang', 'Juntinyuat', 'Kandanghaur', 'Karangampel',
            'Kedokan Bunder', 'Kertasemaya', 'Krangkeng', 'Kroya', 'Lelea',
            'Lohbener', 'Losarang', 'Pasekan', 'Patrol', 'Sindang',
            'Sliyeg', 'Sukagumiwang', 'Sukra', 'Trisi', 'Tukdana', 'Widasari'
        ];

        return view('preferensi.form', compact('kecamatanList'));
    }

    /**
     * Simpan data preferensi pengguna langsung ke tabel users.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'komoditas'           => 'required|string|max:255',
            'harga_min'           => 'required|integer|min:0',
            'harga_max'           => 'required|integer|gte:harga_min',
            'kecamatan'           => 'required|string|max:255',
            'prediksi_panen'      => 'required|date|after_or_equal:today',
            'kapasitas_produksi'  => 'required|integer|min:1',
        ]);

        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $validated['prediksi_panen'])) {
            $tanggal = \DateTime::createFromFormat('d-m-Y', $validated['prediksi_panen']);
            $validated['prediksi_panen'] = $tanggal->format('Y-m-d');
        }

        // Simpan preferensi ke user yang sedang login
        /** @var \App\Models\User $user */
        $user = Auth::user();

        foreach ($validated as $key => $value) {
            $user->$key = $value;
        }

        $user->save();

        return redirect()->route('home')->with('success', 'Preferensi berhasil disimpan.');
    }
}

        /** @var \App\Models\User $user */

