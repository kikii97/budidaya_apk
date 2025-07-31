<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\Produk;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    protected $notifikasiController;

    public function __construct(NotifikasiController $notifikasiController)
    {
        $this->notifikasiController = $notifikasiController;
    }

    public function store(Request $request)
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            Log::warning('No authenticated web user found when creating order.', ['request' => $request->all()]);
            return redirect()->route('login')->with('error', 'Anda harus login untuk membuat pesanan.');
        }

        $validated = $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'nama_customer' => 'required|string|max:255',
            'no_hp_customer' => 'required|string|max:20',
            'jumlah' => 'required|integer|min:1',
            'tanggal_order' => 'required|date',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $data = array_merge($validated, [
            'status' => 'pending',
            'user_id' => $user->id,
        ]);

        $order = Order::create($data);
        $produk = Produk::find($validated['produk_id']);

        if ($produk) {
            $title = "Pesanan Baru dari {$validated['nama_customer']}";
            $detail = [
                'judul' => $title,
                'message' => "Pesanan baru untuk {$produk->jenis_komoditas} telah diterima.",
                'order_id' => $order->id,
                'produk_id' => $produk->id,
                'no_hp' => $validated['no_hp_customer'],
                'tanggal_order' => \Carbon\Carbon::parse($order->tanggal_order)->translatedFormat('d M Y, H:i'),
                'jumlah' => "{$validated['jumlah']} kg",
                'catatan' => $validated['keterangan'] ?? '-',
                'jenis_produk' => $produk->jenis_komoditas,
                'kapasitas' => "{$produk->kapasitas_produksi} kg",
                'prediksi_panen' => \Carbon\Carbon::parse($produk->prediksi_panen)->translatedFormat('d M Y'),
                'tanggal_diunggah' => \Carbon\Carbon::parse($produk->created_at)->translatedFormat('d M Y'),
                'export_url' => route('order.export', $order->id),
            ];

            $success = $this->notifikasiController->kirimNotifikasiKePembudidaya(
                $produk->id,
                $title,
                $detail
            );

            if (!$success) {
                Log::error('Failed to send notification to pembudidaya.', ['produk_id' => $produk->id, 'order_id' => $order->id]);
            }
        } else {
            Log::error('Produk not found for order.', ['produk_id' => $validated['produk_id'], 'order_id' => $order->id]);
        }

        return redirect()->back()->with('success', 'Order berhasil dikirim dan notifikasi terkirim.');
    }

    public function confirm(Request $request, $order_id)
    {
        $order = Order::findOrFail($order_id);
        $produk = Produk::findOrFail($order->produk_id);
        $pembudidaya = Auth::guard('pembudidaya')->user();

        if (!$pembudidaya || $produk->pembudidaya_id !== $pembudidaya->id) {
            \Log::error('Unauthorized attempt to confirm order.', ['order_id' => $order_id, 'pembudidaya_id' => $pembudidaya?->id]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $order->update(['status' => 'confirmed']);

        $user = $order->user_id ? User::find($order->user_id) : null;

        if ($user) {
            $detail = [
                'judul' => "Pesanan Anda Telah Dikonfirmasi",
                'message' => "Pesanan Anda untuk {$produk->jenis_komoditas} telah dikonfirmasi oleh pembudidaya.",
                'order_id' => $order->id,
                'produk_id' => $produk->id,
                'no_hp' => $order->no_hp_customer,
                'tanggal_order' => \Carbon\Carbon::parse($order->tanggal_order)->translatedFormat('d M Y, H:i'),
                'jumlah' => $order->jumlah . ' kg',
                'catatan' => $order->keterangan ?? '-',
                'jenis_produk' => $produk->jenis_komoditas,
                'kapasitas' => "{$produk->kapasitas_produksi} kg",
                'prediksi_panen' => \Carbon\Carbon::parse($produk->prediksi_panen)->translatedFormat('d M Y'),
                'tanggal_diunggah' => \Carbon\Carbon::parse($produk->created_at)->translatedFormat('d M Y'),
                'tanggal_disetujui' => now()->translatedFormat('d M Y, H:i'),
                'export_url' => route('order.export', $order->id),
            ];

            \Log::info('Preparing to send confirmation notification to user.', [
                'order_id' => $order->id,
                'user_id' => $user->id,
                'detail' => $detail
            ]);

            $success = $this->notifikasiController->kirimNotifikasiKeUser(
                $user->id,
                $detail['judul'],
                $detail['message'],
                $detail
            );

            if ($success) {
                \Log::info('Confirmation notification sent to user.', ['order_id' => $order->id, 'user_id' => $user->id]);
            } else {
                \Log::error('Failed to send confirmation notification to user.', ['order_id' => $order->id, 'user_id' => $user->id]);
            }
        } else {
            \Log::warning('User not found for order confirmation.', ['order_id' => $order_id, 'user_id' => $order->user_id]);
        }

        return redirect()->back()->with('success', 'Pesanan telah dikonfirmasi dan notifikasi terkirim ke pelanggan.');
    }

    public function export($id)
    {
        $order = Order::findOrFail($id);
        $produk = Produk::findOrFail($order->produk_id);
        $pembudidaya = Auth::guard('pembudidaya')->user();
        $user = Auth::guard('web')->user();

        if ((!$pembudidaya || $produk->pembudidaya_id !== $pembudidaya->id) && (!$user || $order->user_id !== $user->id)) {
            Log::error('Unauthorized attempt to export order.', [
                'order_id' => $id,
                'pembudidaya_id' => $pembudidaya?->id,
                'user_id' => $user?->id
            ]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = [
            'order_id' => $order->id,
            'nama_customer' => $order->nama_customer,
            'no_hp_customer' => $order->no_hp_customer,
            'jumlah' => $order->jumlah,
            'tanggal_order' => \Carbon\Carbon::parse($order->tanggal_order)->translatedFormat('d M Y, H:i'),
            'keterangan' => $order->keterangan ?? '-',
            'jenis_komoditas' => $produk->jenis_komoditas,
            'jenis_spesifik_komoditas' => $produk->jenis_spesifik_komoditas ?? null,
            'kapasitas_produksi' => $produk->kapasitas_produksi ?? 0,
            'masa_produksi_puncak' => $produk->masa_produksi_puncak ?? null,
            'prediksi_panen' => \Carbon\Carbon::parse($produk->prediksi_panen)->translatedFormat('d M Y'),
            'kisaran_harga_min' => $produk->kisaran_harga_min ?? null,
            'kisaran_harga_max' => $produk->kisaran_harga_max ?? null,
            'detail' => $produk->detail ?? null,
            'telepon' => $produk->telepon,
            'alamat_lengkap' => $produk->alamat_lengkap,
            'kecamatan' => $produk->kecamatan,
            'desa' => $produk->desa,
            'latitude' => $produk->latitude,
            'longitude' => $produk->longitude,
            'tanggal_diunggah' => \Carbon\Carbon::parse($produk->created_at)->translatedFormat('d M Y'),
        ];

        $pdf = Pdf::loadView('order', $data);
        return $pdf->download('order_' . $order->id . '.pdf');
    }
}