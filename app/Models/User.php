<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use \Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Permission\Traits\HasRoles; // <-- Importante

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles; // <-- Agregar esto


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'tipo_documento',
        'numero_documento',
        'fecha_nacimiento',
        'telefono',
        'direccion',
        'role',
        'activo',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    //          * ESTE ES EL ACCESSOR MÁGICO.
    //  * Intercepta cualquier llamada a la propiedad 'name' y devuelve
    //  * el valor de la propiedad 'nombres' en su lugar.
    //  *
    //  * @return \Illuminate\Database\Eloquent\Casts\Attribute
    //  */
    protected function name(): Attribute
    {
        return new Attribute(
            get: fn() => $this->nombres,
        );
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'integer',
            'fecha_nacimiento' => 'date',
            'es_docente' => 'boolean',
            // 'role' => UserRole::class
        ];
    }
    public function getAuthPassword()
    {
        return $this->password;
    }
    public function docente()
    {
        return $this->hasOne(Docente::class, 'user_id');
    }
    public function padre()
    {
        return $this->hasOne(Padre::class, 'user_id');
    }
    public function alumno()
    {
        return $this->hasOne(Alumno::class, 'user_id', 'id');
    }
    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->apellido_paterno . ' ' . $this->apellido_materno;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\QueuedResetPassword($token));
    }
    public function inscripcion(){
        return $this->hasOne(Inscripcion::class,'user_id','id');
    }

}
