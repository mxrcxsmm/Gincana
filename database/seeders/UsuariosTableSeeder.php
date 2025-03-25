<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('usuarios')->insert([
            [
                'nombre'      => 'Admin User',
                'email'       => 'admin@example.com',
                'password'    => Hash::make('qweQWE123'),
                'role_id'     => 1,
                'grupo_id'    => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nombre'      => 'Regular User',
                'email'       => 'user@example.com',
                'password'    => Hash::make('qweQWE123'),
                'role_id'     => 2,
                'grupo_id'    => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nombre'      => 'Trallalero Trallala',
                'email'       => 'trallarero@example.com',
                'password'    => Hash::make('password'),
                'role_id'     => 2,
                'grupo_id'    => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
