<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gimcana extends Model
{
    protected $table = 'gimcanas';

    protected $fillable = ['nombre', 'descripcion'];

    // Relación muchos a muchos con PuntoControl
    public function puntosControl()
    {
        return $this->belongsToMany(PuntoControl::class, 'gimcana_punto_control', 'gimcana_id', 'punto_control_id')
                    ->withTimestamps();
    }
}
