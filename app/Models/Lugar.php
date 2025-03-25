<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    protected $table = 'lugares';
    protected $fillable = [
        'nombre',
        'descripcion',
        'direccion',
        'latitud',
        'longitud',
        'marker'
    ];

    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class, 'lugar_etiqueta', 'lugar_id', 'etiqueta_id');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'lugar_id');
    }

    public function puntosControl()
    {
        return $this->hasMany(PuntoControl::class, 'lugar_id');
    }

        public function lugar()
    {
        return $this->belongsTo(Lugar::class, 'lugar_id');
    }
}
