<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PuntosControlTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('puntos_control')->insert([
            [
                'lugar_id'    => 1,
                'descripcion' => 'Punto de control 1',
                'pista'       => 'Sigue las señales',
                'prueba'      => 'Resuelve el enigma',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'lugar_id'    => 2,
                'descripcion' => 'Punto de control 2',
                'pista'       => 'Busca la pista en la zona',
                'prueba'      => 'Realiza la prueba',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
