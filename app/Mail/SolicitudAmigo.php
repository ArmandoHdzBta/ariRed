<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudAmigo extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Alguien te quiere agregar como amigo";
    public $datos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($usuario)
    {
        $this->datos = $usuario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.solicitud');
    }
}
