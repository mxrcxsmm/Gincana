<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    protected $table = 'etiquetas';
    protected $fillable = ['nombre', 'color'];

    public function lugares()
    {
        return $this->belongsToMany(Lugar::class, 'lugar_etiqueta', 'etiqueta_id', 'lugar_id');
    }
}