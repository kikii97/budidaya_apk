<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:pembudidaya');
    }

    public function index()
    {
        $pembudidaya = Auth::guard('pembudidaya')->user();
        $profil = $pembudidaya->profil;
        $produk = Produk::where('pembudidaya_id', $pembudidaya->id)->get();
    
        return view('profil_pembudidaya', compact('pembudidaya', 'profil', 'produk'));
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
        $data['alamat_lengkap'] = $data['address'];
        $data['jenis_komoditas'] = $data['commodity_type'];
        $data['kisaran_harga_min'] = $data['price_range_min'];
        $data['kisaran_harga_max'] = $data['price_range_max'];
        $data['jenis_spesifik_komoditas'] = $data['specific_commodity_type'];
        $data['kapasitas_produksi'] = $data['production_capacity'];
        $data['masa_produksi_puncak'] = $data['peak_production_period'];
        $data['prediksi_panen'] = $data['harvest_prediction'];
        $data['detail'] = $data['details'];

        if (!empty($data['prediksi_panen'])) {
            $data['prediksi_panen'] = Carbon::createFromFormat('d-m-Y', $data['prediksi_panen'])->format('Y-m-d');
        }
    
        // 🔥 Hapus field input yang tidak ada di database
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
            $data['details']
        );
            
        Produk::create($data);
    
        return redirect()->route('pembudidaya.profil')->with('success', 'Komoditas berhasil diunggah!');
    }
    

    // ➡️ Menampilkan form edit produk
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kecamatanList = $this->getKecamatanList();  
        return view('pembudidaya.edit_produk', compact('produk', 'kecamatanList'));
    }
    

    // ➡️ Menyimpan perubahan edit produk
    public function update(Request $request, $id)
    {
        $produk = Produk::where('pembudidaya_id', Auth::guard('pembudidaya')->id())
                        ->where('id', $id)
                        ->firstOrFail();

        $data = $this->validateProduk($request);

        // Kalau upload gambar baru, hapus gambar lama
        if ($request->hasFile('images')) {
            if ($produk->gambar) {
                foreach (json_decode($produk->gambar) as $gambar) {
                    Storage::disk('public')->delete('images/' . $gambar);
                }
            }
            $data['gambar'] = json_encode($this->uploadImages($request->file('images')));
        }

        $produk->update($data);

        return redirect()->route('pembudidaya.profil')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
    
        // Optional: pastikan hanya pemilik produk bisa hapus
        if ($produk->pembudidaya_id != auth('pembudidaya')->id()) {
            abort(403, 'Unauthorized');
        }
    
        $produk->delete();
    
        return redirect()->route('pembudidaya.profil')->with('success', 'Produk berhasil dihapus.');
    }

    // 🔹 Helper: Validasi data produk
    private function validateProduk(Request $request)
    {
        return $request->validate([
            'images' => 'sometimes|array',
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
            'harvest_prediction' => 'nullable|date_format:d-m-Y',
            'details' => 'nullable|string',
        ], [
            'images.*.mimes' => 'Gambar harus format JPEG, PNG, atau JPG.',
            'images.*.max' => 'Ukuran gambar maksimal 2MB.',
        ]);
    }

    // 🔹 Helper: Upload gambar
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

    // 🔹 Helper: List kecamatan
    private function getKecamatanList()
    {
        return [
            'Anjatan', 'Arahan', 'Balongan', 'Bangodua', 'Bongas', 'Cantigi',
            'Cikedung', 'Gabuswetan', 'Gantar', 'Haurgeulis', 'Indramayu',
            'Jatibarang', 'Juntinyuat', 'Kandanghaur', 'Karangampel', 'Kedokan Bunder',
            'Kertasemaya', 'Krangkeng', 'Kroya', 'Lelea', 'Lohbener', 'Losarang',
            'Pasekan', 'Patrol', 'Sindang', 'Sliyeg', 'Sukagumiwang', 'Sukra',
            'Trisi', 'Tukdana', 'Widasari'
        ];
    }
}
