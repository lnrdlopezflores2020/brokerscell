<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    // Define el nombre exacto de tu tabla en la BD
    protected $table = 'administrador';

    // Define tu llave primaria si no es 'id'
    protected $primaryKey = 'Id_admin'; // (Ajusta esto según tu BD)
}
