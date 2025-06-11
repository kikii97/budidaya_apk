<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NotifikasiPembudidaya extends Notification
{
    use Queueable;

    protected $title;
    protected $message;

    public function __construct($title, $message)
    {
        $this->title = $title;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

public function toDatabase($notifiable)
{
    return [
        'judul' => $this->title,
        'pesan' => $this->message,
        'no_hp' => $this->message['no_hp'] ?? null,
        'tanggal_order' => $this->message['tanggal_order'] ?? null,
        'jumlah' => $this->message['jumlah'] ?? null,
        'catatan' => $this->message['catatan'] ?? null,
        'jenis_produk' => $this->message['jenis_produk'] ?? null,
        'kapasitas' => $this->message['kapasitas'] ?? null,
        'prediksi_panen' => $this->message['prediksi_panen'] ?? null,
        'tanggal_diunggah' => $this->message['tanggal_diunggah'] ?? null,
    ];
}

}
