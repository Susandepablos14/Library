<?php 

namespace App\Traits;

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

trait Messageable
{
    public function sendEmail(string $email, Mailable $mailable): void 
    {
        Mail::to($email)->queue($mailable);
    }
}
