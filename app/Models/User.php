<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'rol',
        'estado',
        'password',
        'empresa',
        'razon_social',
        'nit',
    ];
    public function informacionUsuario()
    {
        return $this->hasOne(InformacionUsuario::class);
    }
    public function contactos()
    {
        return $this->hasMany(Contacto_usuario::class);
    }
    public function ubicaciones()
    {
        return $this->hasMany(Ubicaciones_usuario::class);
    }
    public function pagosRealizados()
    {
        return $this->hasMany(Pago::class, 'trabajador_id');
    }
    public function pagosRecibidos()
    {
        return $this->hasMany(Pago::class, 'cliente_id');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
