<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    
    protected $fillable = [
        'nombre', 
        'email', 
        'password', 
        'role_id',
        'grupo_id'
    ];
    
    protected $hidden = [
        'password', 
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'usuario_grupo', 'usuario_id', 'grupo_id')
                    ->withTimestamps();
    }

    public function puntos()
    {
        return $this->belongsToMany(\App\Models\PuntoControl::class, 'usuario_punto')
                    ->withPivot('completado', 'fecha_completado')
                    ->withTimestamps();
    }
    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'usuario_id');
    }
}
