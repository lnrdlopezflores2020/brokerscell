<?php

namespace App\Mail;

use App\Models\Reparacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReparacionTerminada extends Mailable
{
    use Queueable, SerializesModels;

    public $reparacion;

    public function __construct(Reparacion $reparacion)
    {
        $this->reparacion = $reparacion;
    }

    public function build()
    {
        return $this->subject('¡Buenas noticias! Tu equipo está listo - SoluxMovil')
                    ->view('cpanel/emails/reparacion_terminada');
    }
}