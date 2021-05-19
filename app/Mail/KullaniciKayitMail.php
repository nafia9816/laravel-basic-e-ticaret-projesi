<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Kullanici;

class KullaniciKayitMail extends Mailable
{
    use Queueable, SerializesModels;

    public $kullanici;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Kullanici $kullanici)
    {
        $this->kullanici=$kullanici;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    //mail ile ilgili ayarlamaları burada yapıcaz.
    public function build()
    {
        return $this->
               from('denemefincan@gmail.com')
               ->subject(config('app.name') . ' - Kullanıcı Kaydı')
               ->view('emails.kullanici_kayit');
    }
}
