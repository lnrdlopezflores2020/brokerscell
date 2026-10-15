<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    // Define el nombre exacto de tu tabla en la Base de Datos
    protected $table = 'cliente';

    // Define la llave primaria de esa tabla (ej. ID_cliente)
    protected $primaryKey = 'ID_client';

    // Si tu tabla cliente NO tiene created_at/updated_at, pon esto en false
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'direccion',
        'num_ext',
        'num_int',
        'usuario_fk',
        'amat' // NUEVO CAMPO: Apellido Materno
    ];
    public function usuario()
    {
        // CAMBIA 'user_id' por el nombre real de tu llave foránea en la tabla clientes
        // Si tu columna se llama 'ID_usuario', pon 'ID_usuario'
        return $this->belongsTo(User::class, 'usuario_fk');
    }
}
