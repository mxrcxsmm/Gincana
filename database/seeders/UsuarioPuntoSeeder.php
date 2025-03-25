<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioPuntoSeeder extends Seeder
{
    public function run()
    {
        DB::table('usuario_punto')->insert([
            [
                'usuario_id'       => 2,
                'punto_id'         => 1,
                'completado'       => false,
                'fecha_completado' => now(),
            ],
        ]);
    }
}
