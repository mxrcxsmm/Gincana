<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos';

    // Agregamos 'gimcana_id' para que se pueda asignar masivamente
    protected $fillable = ['nombre', 'descripcion', 'gimcana_id'];

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuario_grupo', 'grupo_id', 'usuario_id')
                    ->withTimestamps();
    }

    // Relación con Gimcana
    public function gimcana()
    {
        return $this->belongsTo(Gimcana::class, 'gimcana_id');
    }
}
