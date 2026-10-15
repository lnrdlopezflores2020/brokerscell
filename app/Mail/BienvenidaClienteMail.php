<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BienvenidaClienteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nombreCliente;

    public function __construct($nombreCliente)
    {
        $this->nombreCliente = $nombreCliente;
    }

    public function build()
    {
        return $this->subject('¡Bienvenid@ a SoluxMovil! Instrucciones de Servicio')
                    ->view('cpanel/emails/bienvenida'); // Llama a la vista que crearemos
    }
}