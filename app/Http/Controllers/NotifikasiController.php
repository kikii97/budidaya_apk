<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;


class NotifikasiController extends Controller
{
    // Fungsi kirim notifikasi ke pembudidaya berdasarkan produk_id dan pesan
    public function kirimNotifikasiKePembudidaya($produk_id, $title, $message)
    {
        $produk = Produk::find($produk_id);

        if (!$produk || !$produk->pembudidaya) {
            return false; // Produk atau pembudidaya tidak ditemukan
        }

        $pembudidaya = $produk->pembudidaya;

        DB::table('notifications')->insert([
            'id' => (string) Str::uuid(),
            'type' => 'App\\Notifications\\CustomNotification',
            'notifiable_type' => 'App\\Models\\Pembudidaya',
            'notifiable_id' => $pembudidaya->id,
            'data' => json_encode([
                'title' => $title,
                'message' => $message,
                'produk_id' => $produk->id,
            ]),
            'read_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return true;
    }

    // Tandai satu notifikasi sebagai sudah dibaca
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

    // Tandai semua notifikasi sebagai sudah dibaca
    public function markAllAsRead()
    {
        $user = Auth::guard('pembudidaya')->user();

        if ($user) {
            $user->unreadNotifications->markAsRead();
        }

        return back()->with('success', 'Semua notifikasi telah dibaca.');
    }
}
