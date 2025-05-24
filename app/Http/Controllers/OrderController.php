<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Produk;

class OrderController extends Controller
{
    protected $notifikasiController;

    public function __construct(NotifikasiController $notifikasiController)
    {
        $this->notifikasiController = $notifikasiController;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'nama_customer' => 'required|string|max:255',
            'no_hp_customer' => 'required|string|max:20',
            'jumlah' => 'required|integer|min:1',
            'tanggal_order' => 'required|date',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $order = Order::create($validated);

        // Kirim notifikasi ke pembudidaya
$produk = Produk::find($validated['produk_id']);

if ($produk) {
$title = "Pesanan Baru dari {$validated['nama_customer']}";

$data = [
    'judul' => $title,
    'no_hp' => $validated['no_hp_customer'],
    'tanggal_order' => now()->format('d M Y, H:i'),
    'jumlah' => "{$validated['jumlah']} kg",
    'catatan' => $validated['keterangan'] ?? '-',
    'jenis_produk' => $produk->jenis_komoditas,
    'kapasitas' => "{$produk->kapasitas_produksi} kg",
    'prediksi_panen' => \Carbon\Carbon::parse($produk->prediksi_panen)->translatedFormat('d M Y'),
    'tanggal_diunggah' => \Carbon\Carbon::parse($produk->created_at)->translatedFormat('d M Y'),
];

$this->notifikasiController->kirimNotifikasiKePembudidaya($produk->id, $data);
}

        return redirect()->back()->with('success', 'Order berhasil dikirim dan notifikasi terkirim.');
    }
}
