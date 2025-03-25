<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['nombre'];
    
    // Asumiendo que la tabla roles no tiene timestamps
    public $timestamps = false;

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'role_id');
    }
}
