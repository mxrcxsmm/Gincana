<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoritosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('favoritos')->insert([
            [
                'nombre_etiqueta' => 'Favorito A',
                'usuario_id'      => 2,
                'lugar_id'        => 1,
                'created_at'      => now(),
            ],
        ]);
    }
}
