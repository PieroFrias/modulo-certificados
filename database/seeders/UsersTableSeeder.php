<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'iiapmodulo.22.certificado@gmail.com',
            'password' => Hash::make('@$YST3m#ñIiAP##Certi'), // Encriptar la contraseña
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
