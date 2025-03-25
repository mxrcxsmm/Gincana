<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LugarEtiquetaSeeder extends Seeder
{
    public function run()
    {
        DB::table('lugar_etiqueta')->insert([
            [
                'lugar_id'    => 1,
                'etiqueta_id' => 1,
            ],
            [
                'lugar_id'    => 2,
                'etiqueta_id' => 2,
            ],
        ]);
    }
}
