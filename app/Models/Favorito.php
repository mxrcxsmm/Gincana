<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    protected $table = 'favoritos';
    protected $fillable = [
        'nombre_etiqueta',
        'usuario_id',
        'lugar_id'
    ];

    // Se utiliza el timestamp creado automáticamente (created_at)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function lugar()
    {
        return $this->belongsTo(Lugar::class, 'lugar_id');
    }
}
