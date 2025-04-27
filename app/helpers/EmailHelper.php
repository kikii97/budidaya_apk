<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Part\HtmlPart;

class EmailHelper
{
    public static function sendEmail($to, $subject, $body)
    {
        Mail::send([], [], function ($message) use ($to, $subject, $body) {
            $message->to($to)
                    ->subject($subject)
                    ->html($body); // Ganti .html() bukan setBody()!
        });
    }
}
