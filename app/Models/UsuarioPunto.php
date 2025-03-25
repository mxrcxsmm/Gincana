<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioPunto extends Model
{
    protected $table = 'usuario_punto';
    public $timestamps = false; // No se definen campos created_at o updated_at

    protected $fillable = ['usuario_id', 'punto_id', 'completado', 'fecha_completado'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function puntoControl()
    {
        return $this->belongsTo(PuntoControl::class, 'punto_id');
    }
}
