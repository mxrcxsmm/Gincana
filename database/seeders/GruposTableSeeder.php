<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GruposTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('grupos')->insert([
            [
                'nombre'      => 'Grupo 1',
                'descripcion' => 'Descripción del Grupo 1',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nombre'      => 'Grupo 2',
                'descripcion' => 'Descripción del Grupo 2',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
