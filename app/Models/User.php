<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre', 'emai', 'rol_usuario', 'contrasenia',
        'codigo_2fa', 'expiracion_2fa' // <--- Agrega estos dos
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // 1. Definir tu tabla personalizada
    protected $table = 'usuario';

    // 2. Definir tu llave primaria (si no es 'id')
    protected $primaryKey = 'ID_usuario';

    // 3. ESTO ES VITAL: Decirle a Laravel cuál es tu columna de contraseña
    public function getAuthPassword()
    {
        return $this->contrasenia; // Retorna el nombre de TU columna en la BD
    }
    public function datosAdmin() {
        return $this->hasOne(Administrador::class, 'usuario_fk', 'ID_usuario');
    }

    public function datosTecnico() {
        // Asumiendo que tu tabla se llama 'tecnico' y la llave foránea es 'ID_usuario'
        return $this->hasOne(Tecnico::class, 'usuario_fk', 'ID_usuario');
    }

    public function datosCliente() {
        // Asumiendo que tu tabla se llama 'cliente' y la llave foránea es 'ID_usuario'
        return $this->hasOne(Cliente::class, 'usuario_fk', 'ID_usuario');
    }
}
