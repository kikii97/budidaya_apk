<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NotifikasiPembudidaya extends Notification
{
    use Queueable;

    protected $title;
    protected $pesan;
    protected $detail;

    public function __construct($title, $pesan, $detail = [])
    {
        $this->title = $title;
        $this->pesan = $pesan;
        $this->detail = $detail;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return array_merge([
            'judul' => $this->title,
            'pesan' => $this->pesan, // Ini string, bukan array
        ], $this->detail);
    }
}
