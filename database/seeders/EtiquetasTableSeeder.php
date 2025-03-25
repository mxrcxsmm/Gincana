<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtiquetasTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('etiquetas')->insert([
            [
                'nombre'     => 'Museo',
                'color'      => '#FF5733',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Restaurante',
                'color'      => '#33FF57',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
