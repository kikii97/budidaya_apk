<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PembudidayaStatusNotification extends Notification
{
    use Queueable;

    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        if ($this->status == 'approved') {
            return (new MailMessage)
                        ->subject('Akun Anda Disetujui')
                        ->greeting('Selamat!')
                        ->line('Akun Anda sebagai Pembudidaya telah disetujui.')
                        ->action('Login Sekarang', url('/login'))
                        ->line('Terima kasih telah bergabung!');
        } elseif ($this->status == 'rejected') {
            return (new MailMessage)
                        ->subject('Akun Anda Ditolak')
                        ->greeting('Mohon Maaf')
                        ->line('Pendaftaran akun Anda sebagai Pembudidaya ditolak.')
                        ->line('Silakan hubungi admin untuk informasi lebih lanjut.');
        }
    }
}
