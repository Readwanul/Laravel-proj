<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable; 
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $email;
    public $name;
    public $messagebody;
    public function __construct($email, $name)
    {
        $this->email = $email;
        $this->name = $name;
        $this->messagebody = "YAHOO";
    }

    public function build()
    {
        return $this->subject("Laravel Mail Test")
                ->view('test');

    }

    public function attachments()
    {
        return [];
    }
}
