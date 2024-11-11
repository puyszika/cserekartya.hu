<?php

namespace App\Mail;


use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use SerializesModels;

    public $data;

    // Kapott adatokat beállítjuk
    public function __construct($data)
    {
        $this->data = $data;
    }

    // E-mail felépítése
    public function build()
    {
        return $this->subject('Új kapcsolatfelvétel üzenet')
            ->view('emails.contact')
            ->with('data', $this->data);
    }
}
