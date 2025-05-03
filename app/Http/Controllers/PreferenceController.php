<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPreference;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    /**
     * Tampilkan form pengisian preferensi jika belum diisi.
     */
    public function create()
    {
        $user = Auth::user();
        $existingPreference = UserPreference::where('user_id', $user->id)->first();

        if ($existingPreference) {
            return redirect()->route('home')->with('info', 'Anda sudah mengisi preferensi.');
        }

        return view('preferensi.form');
    }

    /**
     * Simpan data preferensi pengguna.
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

        UserPreference::updateOrCreate(
            ['user_id' => Auth::id()],
            array_merge($validated, ['user_id' => Auth::id()])
        );

        return redirect()->route('home')->with('success', 'Preferensi berhasil disimpan.');
    }
}
