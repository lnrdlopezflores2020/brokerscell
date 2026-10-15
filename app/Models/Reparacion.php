<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reparacion extends Model
{
    use HasFactory;

    protected $table = 'reparacion';
    protected $primaryKey = 'ID_rep';
    public $timestamps = false;



    protected $fillable = [
        'descripcion',
        'fec_inicio',
        'fec_est_entrega',
        'est_reparacion',
        'id_tel_fk'
    ];

    // 5. CASTS: Convertir automáticamente las fechas a objetos Carbon
    // Esto te permitirá usar $reparacion->fec_inicio->format('d-m-Y') en la vista
    protected $casts = [
        'fec_inicio' => 'date',
        'fec_est_entrega' => 'date',
    ];

    // RELACIONES

    // Una reparación pertenece a un Dispositivo
    public function dispositivo()
    {
        return $this->belongsTo(Dispositivo::class, 'id_tel_fk', 'ID_tel');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_client_fk', 'ID_client');
    }

    // 1. Para mostrar el texto SIN la firma (limpio)
    public function getDescripcionLimpiaAttribute()
    {
        return preg_replace('/\|\|TEC:.*?\|\|/', '', $this->descripcion);
    }

// 2. Para obtener SOLO el nombre del técnico
    public function getTecnicoNombreAttribute()
    {
        preg_match('/\|\|TEC:(.*?)\|\|/', $this->descripcion, $matches);
        return $matches[1] ?? 'Sin Asignar';
    }
}
