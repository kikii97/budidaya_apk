<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * @method void middleware(string|array $middleware, array $options = [])
 */

class ProdukController extends Controller
{
    public function __construct()
    {
        // Hanya user dengan guard pembudidaya yang bisa akses controller ini
        $this->middleware('auth:pembudidaya');
    }

    // Menampilkan semua produk milik user yang login
    public function index()
    {
        $produk = Produk::where('pembudidaya_id', Auth::guard('pembudidaya')->id())->get();
        return view('profil_pembudidaya', compact('produk'));
    }

    // Menampilkan form unggah produk
    public function create()
    {
        $kecamatanList = [
            'Anjatan', 'Arahan', 'Balongan', 'Bangodua', 'Bongas', 'Cantigi',
            'Cikedung', 'Gabuswetan', 'Gantar', 'Haurgeulis', 'Indramayu',
            'Jatibarang', 'Juntinyuat', 'Kandanghaur', 'Karangampel', 'Kedokan Bunder',
            'Kertasemaya', 'Krangkeng', 'Kroya', 'Lelea', 'Lohbener', 'Losarang',
            'Pasekan', 'Patrol', 'Sindang', 'Sliyeg', 'Sukagumiwang', 'Sukra',
            'Trisi', 'Tukdana', 'Widasari'
        ];

        return view('pembudidaya.unggah', compact('kecamatanList'));
    }

    // Menyimpan produk
    public function store(Request $request)
    {
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'phone' => 'required|digits_between:10,15',
            'kecamatan' => 'required|string',
            'address' => 'required|string',
            'commodity_type' => 'required|string',
            'specific_commodity_type' => 'nullable|string',
            'production_capacity' => 'nullable|integer',
            'peak_production_period' => 'nullable|string',
            'price_range_min' => 'required|numeric|min:0',
            'price_range_max' => 'required|numeric|gte:price_range_min',
            'harvest_prediction' => 'nullable|date_format:d-m-Y', // Memastikan format input
            'details' => 'nullable|string',
        ]);

        // Ubah format tanggal 'DD-MM-YYYY' menjadi 'YYYY-MM-DD'
        $harvestPrediction = \Carbon\Carbon::createFromFormat('d-m-Y', $request->harvest_prediction)->format('Y-m-d');

        $imageNames = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = uniqid() . '-' . $image->getClientOriginalName();
                $image->storeAs('images', $imageName, 'public'); // ← ini yang betul
                $imageNames[] = $imageName;
            }
        }        

        Produk::create([
            'gambar' => json_encode($imageNames),
            'telepon' => $request->phone,
            'kecamatan' => $request->kecamatan,
            'alamat_lengkap' => $request->address,
            'jenis_komoditas' => $request->commodity_type,
            'jenis_spesifik_komoditas' => $request->specific_commodity_type,
            'kapasitas_produksi' => $request->production_capacity,
            'masa_produksi_puncak' => $request->peak_production_period,
            'kisaran_harga_min' => $request->price_range_min,
            'kisaran_harga_max' => $request->price_range_max,
            'prediksi_panen' => $harvestPrediction, // Gunakan tanggal yang sudah diformat
            'detail' => $request->details,
            'pembudidaya_id' => Auth::guard('pembudidaya')->id(),
        ]);

        return redirect()->route('profil_pembudidaya')->with('success', 'Komoditas berhasil diunggah!');
    }
}
