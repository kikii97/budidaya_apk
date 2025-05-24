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
    $title = "🛒 Pesanan Baru dari *{$validated['nama_customer']}*";

$message = 
"Pesanan Baru

Nama Pemesan: {$validated['nama_customer']}
No. HP: {$validated['no_hp_customer']}
Tanggal Order: " . now()->format('d M Y, H:i') . "
Jumlah Dipesan: {$validated['jumlah']} kg
Catatan: " . ($validated['keterangan'] ?? '-') . "

Detail Produk
Jenis: {$produk->jenis_komoditas}
Kapasitas Produksi: {$produk->kapasitas_produksi} kg
Prediksi Panen: " . \Carbon\Carbon::parse($produk->prediksi_panen)->translatedFormat('d M Y') . "
Tanggal Diunggah: " . \Carbon\Carbon::parse($produk->created_at)->translatedFormat('d M Y') . "

Silakan hubungi pemesan untuk proses selanjutnya.";

    $this->notifikasiController->kirimNotifikasiKePembudidaya($produk->id, $title, $message);
}

        return redirect()->back()->with('success', 'Order berhasil dikirim dan notifikasi terkirim.');
    }
}
