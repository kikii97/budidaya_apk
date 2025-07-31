<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\User;
use App\Notifications\NotifikasiPembudidaya;

class NotifikasiController extends Controller
{
    public function kirimNotifikasiKePembudidaya($produk_id, string $judul, array $detail = [])
    {
        $produk = Produk::with('pembudidaya')->find($produk_id);

        if (!$produk || !$produk->pembudidaya) {
            \Log::error('Produk or pembudidaya not found.', ['produk_id' => $produk_id]);
            return false;
        }

        $pembudidaya = $produk->pembudidaya;

        $detail = array_merge([
            'judul' => $judul,
            'message' => $judul,
            'order_id' => $detail['order_id'] ?? null,
            'no_hp' => $detail['no_hp'] ?? null,
            'tanggal_order' => $detail['tanggal_order'] ?? null,
            'jumlah' => $detail['jumlah'] ?? null,
            'catatan' => $detail['catatan'] ?? null,
            'jenis_produk' => $detail['jenis_produk'] ?? null,
            'kapasitas' => $detail['kapasitas'] ?? null,
            'prediksi_panen' => $detail['prediksi_panen'] ?? null,
            'tanggal_diunggah' => $detail['tanggal_diunggah'] ?? null,
            'export_url' => isset($detail['order_id']) ? route('order.export', $detail['order_id']) : null,
        ], $detail);

        \Log::info('Sending notification to pembudidaya.', [
            'produk_id' => $produk_id,
            'pembudidaya_id' => $pembudidaya->id,
            'detail' => $detail
        ]);

        $pembudidaya->notify(new NotifikasiPembudidaya(
            $judul,
            $judul,
            $detail
        ));

        return true;
    }

    public function kirimNotifikasiKeUser($user_id, string $judul, string $pesan, array $detail = [])
    {
        $user = User::find($user_id);

        if (!$user) {
            \Log::error('User not found for notification.', ['user_id' => $user_id]);
            return false;
        }

        $detail = array_merge([
            'judul' => $judul,
            'message' => $pesan,
            'order_id' => $detail['order_id'] ?? null,
            'no_hp' => $detail['no_hp'] ?? null,
            'tanggal_order' => $detail['tanggal_order'] ?? null,
            'jumlah' => $detail['jumlah'] ?? null,
            'catatan' => $detail['catatan'] ?? null,
            'jenis_produk' => $detail['jenis_produk'] ?? null,
            'kapasitas' => $detail['kapasitas'] ?? null,
            'prediksi_panen' => $detail['prediksi_panen'] ?? null,
            'tanggal_diunggah' => $detail['tanggal_diunggah'] ?? null,
            'tanggal_disetujui' => $detail['tanggal_disetujui'] ?? null,
            'export_url' => isset($detail['order_id']) ? route('order.export', $detail['order_id']) : null,
        ], $detail);

        \Log::info('Sending notification to user.', [
            'user_id' => $user_id,
            'detail' => $detail
        ]);

        $user->notify(new NotifikasiPembudidaya(
            $judul,
            $pesan,
            $detail
        ));

        return true;
    }

    public function read($id)
    {
        $user = Auth::guard('pembudidaya')->user() ?? Auth::guard('web')->user();

        if (!$user) {
            \Log::error('Unauthorized attempt to mark notification as read.', ['notification_id' => $id]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['message' => 'Notifikasi telah ditandai sebagai dibaca.'], 200);
    }

    public function markAllRead(Request $request)
    {
        $user = Auth::guard('pembudidaya')->user() ?? Auth::guard('web')->user();

        if (!$user) {
            \Log::error('Unauthorized attempt to mark all notifications as read.', ['ip' => $request->ip(), 'user_agent' => $request->header('User-Agent')]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $count = $user->unreadNotifications()->count();
            $user->unreadNotifications()->update(['read_at' => now()]);
            \Log::info('All notifications marked as read.', ['user_id' => $user->id, 'count' => $count]);
            return response()->json(['message' => 'Semua notifikasi telah dibaca.', 'count' => $count], 200);
        } catch (\Exception $e) {
            \Log::error('Failed to mark all notifications as read.', ['error' => $e->getMessage(), 'user_id' => $user->id]);
            return response()->json(['error' => 'Gagal menandai semua notifikasi. Silakan coba lagi.'], 500);
        }
    }

    public function clearAll(Request $request)
    {
        $user = Auth::guard('pembudidaya')->user() ?? Auth::guard('web')->user();

        if (!$user) {
            \Log::error('Unauthorized attempt to clear all notifications.', ['ip' => $request->ip(), 'user_agent' => $request->header('User-Agent')]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $count = $user->notifications()->count();
            $user->notifications()->delete();
            \Log::info('All notifications cleared.', ['user_id' => $user->id, 'count' => $count]);
            return response()->json(['message' => 'Semua notifikasi telah dihapus.', 'count' => $count], 200);
        } catch (\Exception $e) {
            \Log::error('Failed to clear all notifications.', ['error' => $e->getMessage(), 'user_id' => $user->id]);
            return response()->json(['error' => 'Gagal menghapus semua notifikasi. Silakan coba lagi.'], 500);
        }
    }

    public function show($id)
    {
        $user = Auth::guard('pembudidaya')->user() ?? Auth::guard('web')->user();
        if (!$user) {
            \Log::error('Unauthorized access to notification.', ['notification_id' => $id]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification = $user->notifications()->findOrFail($id);
        \Log::info('Notification data retrieved.', ['notification_id' => $id, 'data' => $notification->data]);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        $data = $notification->data;
        if (is_string($data)) {
            $data = json_decode($data, true) ?? [];
        }

        $data = array_merge([
            'judul' => $data['judul'] ?? 'Detail Notifikasi',
            'message' => $data['message'] ?? $data['pesan'] ?? 'Tidak ada pesan.',
            'no_hp' => $data['no_hp'] ?? null,
            'tanggal_order' => $data['tanggal_order'] ?? null,
            'jumlah' => $data['jumlah'] ?? null,
            'catatan' => $data['catatan'] ?? null,
            'jenis_produk' => $data['jenis_produk'] ?? null,
            'kapasitas' => $data['kapasitas'] ?? null,
            'prediksi_panen' => $data['prediksi_panen'] ?? null,
            'tanggal_diunggah' => $data['tanggal_diunggah'] ?? null,
            'tanggal_disetujui' => $data['tanggal_disetujui'] ?? null,
            'order_id' => $data['order_id'] ?? null,
            'export_url' => isset($data['order_id']) ? route('order.export', $data['order_id']) : null,
        ], $data);

        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }
}