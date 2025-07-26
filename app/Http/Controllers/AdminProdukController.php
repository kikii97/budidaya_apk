<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pembudidaya;
use Illuminate\Support\Facades\Storage;
use App\Notifications\NotifikasiPembudidaya;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $produk = Produk::with('pembudidaya')
            ->orderByRaw("CASE 
                WHEN is_approved IS NULL THEN 0 
                WHEN is_approved = 0 THEN 1 
                WHEN is_approved = 1 THEN 2 
                ELSE 3 END")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.produk.index', compact('produk'));
    }

    public function create()
    {
        $kecamatanList = [
            'Anjatan', 'Arahan', 'Balongan', 'Bangodua', 'Bongas', 'Cantigi',
            'Cikedung', 'Gabuswetan', 'Gantar', 'Haurgeulis', 'Indramayu',
            'Jatibarang', 'Juntinyuat', 'Kandanghaur', 'Karangampel', 'Kedokan Bunder',
            'Kertasemaya', 'Krangkeng', 'Kroya', 'Lelea', 'Lohbener', 'Losarang',
            'Pasekan', 'Patrol', 'Sindang', 'Sliyeg', 'Sukagumiwang', 'Sukra',
            'Terisi', 'Tukdana', 'Widasari'
        ];

        $desaList = [
            'Indramayu' => [
                'Bojongsari', 'Dukuh', 'Karanganyar', 'Karangmalang', 'Karangsong',
                'Kepandean', 'Lemahabang', 'Lemahmekar', 'Margadadi', 'Pabeanudik',
                'Paoman', 'Pekandangan', 'Pekandangan Jaya', 'Plumbon', 'Singajaya',
                'Singaraja', 'Tambak', 'Telukagung'
            ]
        ];

        $pembudidayas = Pembudidaya::whereHas('dokumenPembudidaya', function ($query) {
            $query->where('status', 'disetujui');
        })->where('role', 'pembudidaya')->get(['id', 'name']);

        return view('admin.produk.create', compact('kecamatanList', 'desaList', 'pembudidayas'));
    }

public function store(Request $request)
{
    $request->validate([
        'phone' => 'required|string|min:10|max:15',
        'kecamatan' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'desa' => 'required|string|max:255', // Keep desa for form input
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'commodity_type' => 'required|string|max:255',
        'specific_commodity_type' => 'nullable|string|max:255',
        'production_capacity' => 'nullable|integer|min:0',
        'peak_production_period' => 'nullable|string|max:255',
        'price_range_min' => 'required|numeric|min:0',
        'price_range_max' => 'required|numeric|gte:price_range_min',
        'harvest_prediction' => ['required', function ($attribute, $value, $fail) {
            $bulanIndo = [
                'Januari' => '01', 'Februari' => '02', 'Maret' => '03',
                'April' => '04', 'Mei' => '05', 'Juni' => '06',
                'Juli' => '07', 'Agustus' => '08', 'September' => '09',
                'Oktober' => '10', 'November' => '11', 'Desember' => '12'
            ];

            if (!preg_match('/^\d{1,2} (Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember) \d{4}$/', $value)) {
                return $fail('Tanggal prediksi panen harus dalam format: 31 Juli 2025');
            }

            [$tanggal, $bulan, $tahun] = explode(' ', $value);
            if (!checkdate((int)$bulanIndo[$bulan], (int)$tanggal, (int)$tahun)) {
                return $fail('Tanggal tidak valid.');
            }
        }],
        'details' => 'nullable|string',
        'images' => 'required|array',
        'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        'pembudidaya_id' => [
            'required',
            'exists:pembudidaya,id',
            function ($attribute, $value, $fail) {
                $pembudidaya = Pembudidaya::where('id', $value)
                    ->whereHas('dokumenPembudidaya', function ($query) {
                        $query->where('status', 'disetujui');
                    })
                    ->where('role', 'pembudidaya')
                    ->exists();
                if (!$pembudidaya) {
                    $fail('Pembudidaya yang dipilih belum disetujui atau bukan pembudidaya.');
                }
            },
        ]
    ], [
        'images.required' => 'Harap unggah foto komoditas.',
        'images.*.mimes' => 'Gambar harus berformat JPEG, PNG, atau JPG.',
        'images.*.max' => 'Ukuran gambar maksimal 2MB.',
        'phone.required' => 'Nomor telepon wajib diisi.',
        'kecamatan.required' => 'Kecamatan wajib diisi.',
        'address.required' => 'Alamat lengkap wajib diisi.',
        'desa.required' => 'Desa wajib diisi.',
        'latitude.required' => 'Latitude wajib diisi.',
        'longitude.required' => 'Longitude wajib diisi.',
        'commodity_type.required' => 'Jenis komoditas wajib diisi.',
        'price_range_min.required' => 'Harga minimum wajib diisi.',
        'price_range_max.required' => 'Harga maksimum wajib diisi.',
        'price_range_max.gte' => 'Harga maksimum harus lebih besar atau sama dengan harga minimum.',
        'pembudidaya_id.required' => 'Pembudidaya wajib dipilih.',
        'pembudidaya_id.exists' => 'Pembudidaya tidak valid.'
    ]);

    $gambarBaru = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $imageFile) {
            $namaGambar = Str::uuid()->toString() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->storeAs('images', $namaGambar, 'public');
            $gambarBaru[] = $namaGambar;
        }
    }

    // Combine address and desa into alamat_lengkap
    $alamatLengkap = trim($request->address . ', ' . $request->desa);

    $produk = Produk::create([
        'pembudidaya_id' => $request->pembudidaya_id,
        'telepon' => $request->phone,
        'kecamatan' => $request->kecamatan,
        'alamat_lengkap' => $alamatLengkap, // Use combined address
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'jenis_komoditas' => $request->commodity_type,
        'jenis_spesifik_komoditas' => $request->specific_commodity_type,
        'kapasitas_produksi' => $request->production_capacity,
        'masa_produksi_puncak' => $request->peak_production_period,
        'kisaran_harga_min' => $request->price_range_min,
        'kisaran_harga_max' => $request->price_range_max,
        'prediksi_panen' => $request->harvest_prediction ? $this->parseTanggalIndonesia($request->harvest_prediction) : null,
        'detail' => $request->details,
        'gambar' => json_encode($gambarBaru),
        'is_approved' => null
    ]);

    return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diunggah dan menunggu persetujuan.');
}

    public function edit($id)
    {
        $produk = Produk::with('pembudidaya')->findOrFail($id);
        $pembudidayas = Pembudidaya::whereHas('dokumenPembudidaya', function ($query) {
            $query->where('status', 'disetujui');
        })->where('role', 'pembudidaya')->get(['id', 'name']);

        // The kecamatanList and desaList are not used in the view since kecamatan and desa are readonly and populated via Mapbox
        // But we keep them for consistency with the create method or potential future use
        $kecamatanList = [
            'Anjatan', 'Arahan', 'Balongan', 'Bangodua', 'Bongas', 'Cantigi',
            'Cikedung', 'Gabuswetan', 'Gantar', 'Haurgeulis', 'Indramayu',
            'Jatibarang', 'Juntinyuat', 'Kandanghaur', 'Karangampel', 'Kedokan Bunder',
            'Kertasemaya', 'Krangkeng', 'Kroya', 'Lelea', 'Lohbener', 'Losarang',
            'Pasekan', 'Patrol', 'Sindang', 'Sliyeg', 'Sukagumiwang', 'Sukra',
            'Terisi', 'Tukdana', 'Widasari'
        ];
        $desaList = [
            'Indramayu' => [
                'Bojongsari', 'Dukuh', 'Karanganyar', 'Karangmalang', 'Karangsong',
                'Kepandean', 'Lemahabang', 'Lemahmekar', 'Margadadi', 'Pabeanudik',
                'Paoman', 'Pekandangan', 'Pekandangan Jaya', 'Plumbon', 'Singajaya',
                'Singaraja', 'Tambak', 'Telukagung'
            ]
        ];

        // Decode gambar for use in the view
        $produk->gambar = json_decode($produk->gambar, true) ?? [];

        // Format prediksi_panen to Indonesian format for display
        if ($produk->prediksi_panen) {
            $produk->prediksi_panen = Carbon::parse($produk->prediksi_panen)->format('d F Y');
        }

        return view('admin.produk.edit', compact('produk', 'kecamatanList', 'desaList', 'pembudidayas'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'phone' => 'required|string|min:10|max:15',
            'kecamatan' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'commodity_type' => 'required|string|max:255',
            'specific_commodity_type' => 'nullable|string|max:255',
            'production_capacity' => 'nullable|integer|min:0',
            'peak_production_period' => 'nullable|string|max:255',
            'price_range_min' => 'required|numeric|min:0',
            'price_range_max' => 'required|numeric|gte:price_range_min',
            'harvest_prediction' => ['required', function ($attribute, $value, $fail) {
                $bulanIndo = [
                    'Januari' => '01', 'Februari' => '02', 'Maret' => '03',
                    'April' => '04', 'Mei' => '05', 'Juni' => '06',
                    'Juli' => '07', 'Agustus' => '08', 'September' => '09',
                    'Oktober' => '10', 'November' => '11', 'Desember' => '12'
                ];

                if (!preg_match('/^\d{1,2} (Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember) \d{4}$/', $value)) {
                    return $fail('Tanggal prediksi panen harus dalam format: 31 Juli 2025');
                }

                [$tanggal, $bulan, $tahun] = explode(' ', $value);
                if (!checkdate((int)$bulanIndo[$bulan], (int)$tanggal, (int)$tahun)) {
                    return $fail('Tanggal tidak valid.');
                }
            }],
            'details' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'images_remove' => 'nullable|array',
            'pembudidaya_id' => [
                'required',
                'exists:pembudidaya,id',
                function ($attribute, $value, $fail) {
                    $pembudidaya = Pembudidaya::where('id', $value)
                        ->whereHas('dokumenPembudidaya', function ($query) {
                            $query->where('status', 'disetujui');
                        })
                        ->where('role', 'pembudidaya')
                        ->exists();
                    if (!$pembudidaya) {
                        $fail('Pembudidaya yang dipilih belum disetujui atau bukan pembudidaya.');
                    }
                },
            ]
        ], [
            'images.*.mimes' => 'Gambar harus berformat JPEG, PNG, atau JPG.',
            'images.*.max' => 'Ukuran gambar maksimal 2MB.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'desa.required' => 'Desa wajib diisi.',
            'latitude.required' => 'Latitude wajib diisi.',
            'longitude.required' => 'Longitude wajib diisi.',
            'commodity_type.required' => 'Jenis komoditas wajib diisi.',
            'price_range_min.required' => 'Harga minimum wajib diisi.',
            'price_range_max.required' => 'Harga maksimum wajib diisi.',
            'price_range_max.gte' => 'Harga maksimum harus lebih besar atau sama dengan harga minimum.',
            'pembudidaya_id.required' => 'Pembudidaya wajib dipilih.',
            'pembudidaya_id.exists' => 'Pembudidaya tidak valid.'
        ]);

        // Combine address and desa into alamat_lengkap
        $alamatLengkap = trim($request->address . ', ' . $request->desa);

        // Map form fields to model attributes
        $produk->pembudidaya_id = $request->pembudidaya_id;
        $produk->telepon = $request->phone;
        $produk->kecamatan = $request->kecamatan;
        $produk->alamat_lengkap = $alamatLengkap;
        $produk->latitude = $request->latitude;
        $produk->longitude = $request->longitude;
        $produk->jenis_komoditas = $request->commodity_type;
        $produk->jenis_spesifik_komoditas = $request->specific_commodity_type;
        $produk->kapasitas_produksi = $request->production_capacity;
        $produk->masa_produksi_puncak = $request->peak_production_period;
        $produk->kisaran_harga_min = $request->price_range_min;
        $produk->kisaran_harga_max = $request->price_range_max;
        $produk->prediksi_panen = $request->harvest_prediction ? $this->parseTanggalIndonesia($request->harvest_prediction) : null;
        $produk->detail = $request->details;

        // Handle images
        $gambarLama = is_string($produk->gambar) ? json_decode($produk->gambar, true) : $produk->gambar;
        $gambarLama = $gambarLama ?? [];
        $gambarBaru = [];

        // Process images to remove
        if ($request->has('images_remove')) {
            foreach ($gambarLama as $gambar) {
                if (!in_array($gambar, $request->images_remove)) {
                    $gambarBaru[] = $gambar;
                } else {
                    Storage::disk('public')->delete("images/{$gambar}");
                }
            }
        } else {
            $gambarBaru = $gambarLama;
        }

        // Process new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                if ($imageFile->isValid()) {
                    $namaGambar = Str::uuid()->toString() . '.' . $imageFile->getClientOriginalExtension();
                    $imageFile->storeAs('images', $namaGambar, 'public');
                    $gambarBaru[] = $namaGambar;
                }
            }
        }

        // Check if there are any images (new or existing)
        if (empty($gambarBaru)) {
            return redirect()->back()->withErrors(['images' => 'Harap unggah setidaknya satu gambar atau pertahankan gambar yang ada.'])->withInput();
        }

        $produk->gambar = json_encode($gambarBaru);
        $produk->is_approved = null; // Reset approval status on update
        $produk->save();

        return redirect()->route('admin.produk.index')->with('success', 'Data produk berhasil diperbarui dan menunggu persetujuan.');
    }

    public function show($id)
    {
        $produk = Produk::with('pembudidaya')->findOrFail($id);
        return view('admin.produk.detail', compact('produk'));
    }

    public function approve($id)
    {
        $produk = Produk::with('pembudidaya')->findOrFail($id);

        if (!is_null($produk->is_approved)) {
            return redirect()->back()->with('error', 'Produk sudah memiliki status persetujuan.');
        }

        $produk->is_approved = true;
        $produk->save();

        $pembudidaya = $produk->pembudidaya;

        if ($pembudidaya) {
            $pembudidaya->notify(new NotifikasiPembudidaya(
                'Produk Disetujui',
                'Produk Anda telah disetujui dan akan tampil di halaman pengguna.',
                [
                    'jenis_produk' => $produk->jenis_komoditas . ' - ' . $produk->jenis_spesifik_komoditas,
                    'tanggal_disetujui' => now()->format('Y-m-d'),
                    'tanggal_diunggah' => $produk->created_at->format('Y-m-d')
                ]
            ));
        }

        return redirect()->back()->with('success', 'Produk berhasil disetujui dan akan tampil di halaman pembudidaya & pengguna.');
    }

    public function reject($id)
    {
        $produk = Produk::with('pembudidaya')->findOrFail($id);

        if (!is_null($produk->is_approved)) {
            return redirect()->back()->with('error', 'Produk sudah memiliki status persetujuan.');
        }

        $produk->is_approved = false;
        $produk->save();

        $pembudidaya = $produk->pembudidaya;

        if ($pembudidaya) {
            $pembudidaya->notify(new NotifikasiPembudidaya(
                'Produk Ditolak',
                'Mohon maaf, produk Anda ditolak oleh admin. Silakan periksa kembali data produk.',
                [
                    'jenis_produk' => $produk->jenis_komoditas . ' - ' . $produk->jenis_spesifik_komoditas,
                    'tanggal_ditolak' => now()->format('Y-m-d'),
                    'tanggal_diunggah' => $produk->created_at->format('Y-m-d')
                ]
            ));
        }

        return redirect()->back()->with('success', 'Produk berhasil ditolak.');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->gambar) {
            $gambarList = json_decode($produk->gambar, true);
            foreach ($gambarList as $gambar) {
                Storage::disk('public')->delete("images/{$gambar}");
            }
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    private function parseTanggalIndonesia($tanggalIndo)
    {
        $bulanIndo = [
            'Januari' => 'January', 'Februari' => 'February', 'Maret' => 'March',
            'April' => 'April', 'Mei' => 'May', 'Juni' => 'June',
            'Juli' => 'July', 'Agustus' => 'August', 'September' => 'September',
            'Oktober' => 'October', 'November' => 'November', 'Desember' => 'December'
        ];

        [$tanggal, $bulan, $tahun] = explode(' ', $tanggalIndo);

        if (!isset($bulanIndo[$bulan])) {
            throw new \Exception('Format bulan tidak dikenali.');
        }

        $tanggalInggris = "$tanggal {$bulanIndo[$bulan]} $tahun";

        return Carbon::createFromFormat('d F Y', $tanggalInggris)->format('Y-m-d');
    }
}