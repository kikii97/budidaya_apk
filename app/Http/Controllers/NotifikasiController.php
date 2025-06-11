<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Notifications\NotifikasiPembudidaya;


class NotifikasiController extends Controller
{
    // Kirim notifikasi ke pembudidaya
public function kirimNotifikasiKePembudidaya($produk_id, array $data)
{
    $produk = Produk::find($produk_id);

    if (!$produk || !$produk->pembudidaya) {
        return false;
    }

    $pembudidaya = $produk->pembudidaya;

$pembudidaya->notify(new NotifikasiPembudidaya(
    'Pesanan Baru',
    [
        'no_hp' => '08123456789',
        'tanggal_order' => '2025-06-10',
        'jumlah' => '100kg',
        'catatan' => 'Segera kirim ya!',
        'jenis_produk' => 'Ikan Lele',
        'kapasitas' => '500kg/bulan',
        'prediksi_panen' => '2025-06-30',
        'tanggal_diunggah' => '2025-06-09'
    ]
));


    return true;
}

    // Tandai satu notifikasi sudah dibaca
    public function read($id)
    {
        $user = Auth::guard('pembudidaya')->user();

        if (!$user) {
            abort(403, 'Unauthorized access.');
        }

        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();

        return back()->with('success', 'Notifikasi telah ditandai sebagai dibaca.');
    }

    // Tandai semua notifikasi sudah dibaca
    public function markAllRead()
    {
        $user = Auth::guard('pembudidaya')->user();

        if ($user) {
            $user->unreadNotifications->markAsRead();
        }

        return back()->with('success', 'Semua notifikasi telah dibaca.');
    }
public function show($id)
{
    $user = Auth::guard('pembudidaya')->user();

    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $notification = $user->notifications()->findOrFail($id);

    // Tandai dibaca
    if (is_null($notification->read_at)) {
        $notification->markAsRead();
    }

    // Data bisa jadi masih bentuk string JSON
    $data = $notification->data;

    // Paksa decode manual jika perlu
    if (is_string($data)) {
        $data = json_decode($data, true);
    }

    return response()->json($data);
}
}
