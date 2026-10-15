<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispositivo extends Model
{
    use HasFactory;

    // 1. Nombre de la tabla (Laravel buscaría 'dispositivos')
    protected $table = 'dispositivo';

    // 2. Llave primaria personalizada
    protected $primaryKey = 'ID_tel';

    // 3. Desactivar timestamps si no tienes created_at y updated_at
    public $timestamps = false;

    // 4. Campos que se pueden llenar masivamente (create/update)
    protected $fillable = [
        'tipo',
        'marca',
        'modelo',
        'id_client_fk'
    ];

    // RELACIONES

    // Un dispositivo pertenece a un Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_client_fk', 'ID_client');
    }

    // Un dispositivo puede tener muchas Reparaciones
    public function reparaciones()
    {
        return $this->hasMany(Reparacion::class, 'id_tel_fk', 'ID_tel');
    }
}
