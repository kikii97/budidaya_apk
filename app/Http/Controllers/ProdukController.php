<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:pembudidaya')->only([
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy'
        ]);
    }

    public function show($id)
    {
        $produk = Produk::with('pembudidaya')
            ->where('id', $id)
            ->where('is_approved', true)
            ->firstOrFail();

        return view('detail', compact('produk'));
    }


    // ✅ Tampilkan hanya produk yang sudah disetujui admin
    public function index()
    {
        $pembudidaya = Auth::guard('pembudidaya')->user();
        $profil = $pembudidaya->profil;
        $produk = Produk::where('pembudidaya_id', $pembudidaya->id)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('detail_usaha', compact('pembudidaya', 'profil', 'produk'));
    }

    // Hapus metode berikut dari ProdukController.php
public function home()
{
    $lokasi = Produk::where('is_approved', true)->get([
        'id', 'gambar', 'jenis_komoditas', 'kecamatan', 'desa', 'telepon', 'alamat_lengkap as alamat', 'latitude', 'longitude'
    ]);
    return view('home', compact('lokasi'));
}

    public function create()
    {
        $kecamatanList = $this->getKecamatanList();
        return view('pembudidaya.unggah', compact('kecamatanList'));
    }

    public function store(Request $request)
    {
        $data = $this->validateProduk($request);

        if ($request->hasFile('images')) {
            $data['gambar'] = json_encode($this->uploadImages($request->file('images')));
        }

        $data['pembudidaya_id'] = Auth::guard('pembudidaya')->id();
        $data['telepon'] = $data['phone'];
        $data['telepon'] = $data['phone'];
        $data['alamat_lengkap'] = $data['address'];
        $data['kecamatan'] = $data['kecamatan'];
        $data['desa'] = $data['desa'];
        $data['latitude'] = $data['latitude'];
        $data['longitude'] = $data['longitude'];
        $data['jenis_komoditas'] = $data['commodity_type'];
        $data['kisaran_harga_min'] = $data['price_range_min'];
        $data['kisaran_harga_max'] = $data['price_range_max'];
        $data['jenis_spesifik_komoditas'] = $data['specific_commodity_type'];
        $data['kapasitas_produksi'] = $data['production_capacity'];
        $data['masa_produksi_puncak'] = $data['peak_production_period'];
        $data['prediksi_panen'] = $data['harvest_prediction'];
        $data['detail'] = $data['details'];
        $data['use_geolocation'] = $request->has('use_geolocation') ? 1 : 0;

        if (!empty($data['prediksi_panen'])) {
            $data['prediksi_panen'] = Carbon::createFromFormat('d-m-Y', $data['prediksi_panen'])->format('Y-m-d');
        }

        // Set status persetujuan jadi null (menunggu approval admin)
        $data['is_approved'] = null;

        // Hapus field input yang tidak ada di database
        unset(
            $data['phone'],
            $data['address'],
            $data['commodity_type'],
            $data['price_range_min'],
            $data['price_range_max'],
            $data['specific_commodity_type'],
            $data['production_capacity'],
            $data['peak_production_period'],
            $data['harvest_prediction'],
            $data['details'],
            $data['use_geolocation']
        );

        Produk::create($data);

        return redirect()->route('usaha.detail', Auth::guard('pembudidaya')->id())->with('success', 'Komoditas berhasil ditambahkan dan akan diverifikasi oleh admin. Komoditas akan tampil setelah disetujui.');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kecamatanList = $this->getKecamatanList();
        return view('pembudidaya.edit_produk', compact('produk', 'kecamatanList'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::where('pembudidaya_id', Auth::guard('pembudidaya')->id())
            ->where('id', $id)
            ->firstOrFail();

        $data = $this->validateProduk($request);

        $gambarLama = json_decode($produk->gambar, true) ?? [];

        // 1. Proses penghapusan gambar yang dicentang
        $gambarYangDihapus = $request->input('hapus_gambar', []);
        $gambarTersisa = [];

        foreach ($gambarLama as $gambar) {
            if (in_array($gambar, $gambarYangDihapus)) {
                Storage::disk('public')->delete('images/' . $gambar);
            } else {
                $gambarTersisa[] = $gambar;
            }
        }

        // 2. Proses upload gambar baru (jika ada)
        if ($request->hasFile('images')) {
            $gambarBaru = $this->uploadImages($request->file('images'));
            $semuaGambar = array_merge($gambarTersisa, $gambarBaru);
            $data['gambar'] = json_encode($semuaGambar);
        } else {
            $data['gambar'] = json_encode($gambarTersisa);
        }

        // Mapping field input ke kolom di DB
        $data['telepon'] = $data['phone'];
        $data['latitude'] = $data['latitude'];
        $data['longitude'] = $data['longitude'];
        $data['alamat_lengkap'] = $data['address'];
        $data['kecamatan'] = $data['kecamatan'];
        $data['desa'] = $data['desa'];
        $data['jenis_komoditas'] = $data['commodity_type'];
        $data['kisaran_harga_min'] = $data['price_range_min'];
        $data['kisaran_harga_max'] = $data['price_range_max'];
        $data['jenis_spesifik_komoditas'] = $data['specific_commodity_type'];
        $data['kapasitas_produksi'] = $data['production_capacity'];
        $data['masa_produksi_puncak'] = $data['peak_production_period'];
        $data['prediksi_panen'] = $data['harvest_prediction'];
        $data['detail'] = $data['details'];
        $data['use_geolocation'] = $request->has('use_geolocation') ? 1 : 0;

        if (!empty($data['prediksi_panen'])) {
            $data['prediksi_panen'] = Carbon::createFromFormat('d-m-Y', $data['prediksi_panen'])->format('Y-m-d');
        }

        // Reset status persetujuan
        $data['is_approved'] = null;

        // Hapus field input sementara
        unset(
            $data['phone'],
            $data['address'],
            $data['commodity_type'],
            $data['price_range_min'],
            $data['price_range_max'],
            $data['specific_commodity_type'],
            $data['production_capacity'],
            $data['peak_production_period'],
            $data['harvest_prediction'],
            $data['details'],
            $data['use_geolocation']
        );

        $produk->update($data);

        return redirect()->route('usaha.detail', Auth::guard('pembudidaya')->id())->with('success', 'Komoditas berhasil diperbarui. Perubahan akan ditinjau kembali oleh admin sebelum ditampilkan.');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->pembudidaya_id != auth('pembudidaya')->id()) {
            abort(403, 'Unauthorized');
        }

        if ($produk->gambar) {
            foreach (json_decode($produk->gambar) as $gambar) {
                Storage::disk('public')->delete('images/' . $gambar);
            }
        }

        $produk->delete();

        return redirect()->route('pembudidaya.detail_usaha')->with('success', 'Komoditas berhasil dihapus.');
    }

    private function validateProduk(Request $request)
    {
        return $request->validate([
            'images' => 'sometimes|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'phone' => 'required|digits_between:10,15',
            'kecamatan' => 'required|string',
            'desa' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string',
            'commodity_type' => 'required|string',
            'specific_commodity_type' => 'nullable|string',
            'production_capacity' => 'nullable|integer',
            'peak_production_period' => 'nullable|string',
            'price_range_min' => 'required|numeric|min:0',
            'price_range_max' => 'required|numeric|gte:price_range_min',
            'harvest_prediction' => 'nullable|date_format:d-m-Y',
            'details' => 'nullable|string',
            'use_geolocation' => 'nullable|boolean',
        ], [
            'images.*.mimes' => 'Gambar harus format JPEG, PNG, atau JPG.',
            'images.*.max' => 'Ukuran gambar maksimal 2MB.',
        ]);
    }


    // Untuk menampilkan katalog publik
    public function katalog(Request $request)
    {
        $minPrice = is_numeric($request->input('price_min')) ? (int) $request->input('price_min') : null;
        $maxPrice = is_numeric($request->input('price_max')) ? (int) $request->input('price_max') : null;

        $produkList = Produk::query()->where('is_approved', true);

        if ($request->has('jenis_komoditas') && is_array($request->jenis_komoditas)) {
            $produkList->whereIn('jenis_komoditas', $request->jenis_komoditas);
        }

        if ($minPrice !== null && $maxPrice !== null) {
            if ($minPrice <= $maxPrice) {
                $produkList->where(function ($q) use ($minPrice, $maxPrice) {
                    $q->where('kisaran_harga_min', '<=', $maxPrice)
                        ->where('kisaran_harga_max', '>=', $minPrice);
                });
            }
        } elseif ($minPrice !== null) {
            $produkList->where('kisaran_harga_max', '>=', $minPrice);
        } elseif ($maxPrice !== null) {
            $produkList->where('kisaran_harga_min', '<=', $maxPrice);
        }

        if ($request->has('kecamatan') && is_array($request->kecamatan)) {
            $produkList->whereIn('kecamatan', $request->kecamatan);
        }

        $sortBy = $request->input('sort_by', 'terbaru'); // default 'terbaru'

        if ($sortBy === 'termurah') {
            $produkList = $produkList->orderBy('kisaran_harga_min', 'asc');
        } else {
            // default urut berdasarkan terbaru
            $produkList = $produkList->orderBy('created_at', 'desc');
        }

        $produkList = $produkList->paginate(12)->withQueryString();

        return view('katalog', compact('produkList'));
    }


    private function uploadImages($images)
    {
        $imageNames = [];
        foreach ($images as $image) {
            $imageName = uniqid() . '-' . $image->getClientOriginalName();
            $image->storeAs('images', $imageName, 'public');
            $imageNames[] = $imageName;
        }
        return $imageNames;
    }

    private function getKecamatanList()
    {
        return [
            'Anjatan',
            'Arahan',
            'Balongan',
            'Bangodua',
            'Bongas',
            'Cantigi',
            'Cikedung',
            'Gabuswetan',
            'Gantar',
            'Haurgeulis',
            'Indramayu',
            'Jatibarang',
            'Juntinyuat',
            'Kandanghaur',
            'Karangampel',
            'Kedokan Bunder',
            'Kertasemaya',
            'Krangkeng',
            'Kroya',
            'Lelea',
            'Lohbener',
            'Losarang',
            'Pasekan',
            'Patrol',
            'Sindang',
            'Sliyeg',
            'Sukagumiwang',
            'Sukra',
            'Terisi',
            'Tukdana',
            'Widasari'
        ];
    }

    public function destroyMultiple(Request $request)
    {
        $produkIds = $request->input('produk_ids', []);

        if (empty($produkIds)) {
            return redirect()->back()->with('error', 'Tidak ada produk yang dipilih.');
        }

        Produk::whereIn('id', $produkIds)
            ->where('pembudidaya_id', Auth::guard('pembudidaya')->id())
            ->delete();

        return redirect()->back()->with('success', 'Produk yang dipilih berhasil dihapus.');
    }


}
