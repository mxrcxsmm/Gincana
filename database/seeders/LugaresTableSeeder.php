<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LugaresTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('lugares')->insert([
            [
                'nombre'      => 'Lugar A',
                'descripcion' => 'Campo de futbol de L\'Hospitalet de Llobregat',
                'direccion'   => 'Carrer de la Residencia, 30, 08907 L\'Hospitalet de Llobregat, Barcelona',
                'latitud'     => '41.3460888',
                'longitud'    => '2.0990090',
                'marker'      => 'marker_a.png',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nombre'      => 'Lugar B',
                'descripcion' => 'Pistas de fútbol Promosportive',
                'direccion'   => 'Camí Pau Redó, s/n, 08908 L\'Hospitalet de Llobregat, Barcelona',
                'latitud'     => '41.3449530',
                'longitud'    => '2.1104142',
                'marker'      => 'marker_b.png',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
