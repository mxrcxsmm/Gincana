<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuntoControl extends Model
{
    protected $table = 'puntos_control';
    protected $fillable = ['lugar_id', 'descripcion', 'pista', 'prueba'];
    public function lugar()
    {
        return $this->belongsTo(Lugar::class, 'lugar_id');
    }

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuario_punto')
            ->withPivot('completado', 'fecha_completado')
            ->withTimestamps();
    }
    
    public function gimcanas()
    {
        return $this->belongsToMany(Gimcana::class, 'gimcana_punto_control', 'punto_control_id', 'gimcana_id')
                    ->withTimestamps();
    }
}
