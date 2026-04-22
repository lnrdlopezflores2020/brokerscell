<?php

namespace App\Mail;

use App\Models\Reparacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EstadoReparacionActualizado extends Mailable
{
    use Queueable, SerializesModels;

    public $reparacion;

    public function __construct(Reparacion $reparacion)
    {
        $this->reparacion = $reparacion;
    }

    public function build()
    {
        return $this->subject('Actualización de tu equipo en SoluxMovil')
                    ->view('cpanel/emails/estado_actualizado');
    }
}