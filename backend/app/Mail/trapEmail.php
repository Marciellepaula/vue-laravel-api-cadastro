<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class trapEmail extends Mailable
{
    use Queueable, SerializesModels;


    protected $email;
    protected $password;

    /**
     * Create a new message instance.
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Email de Registração')
            ->view('emailSend')
            ->with([
                'email' => $this->email,
                'password' => $this->password,
            ]);
    }
}