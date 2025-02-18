<?php

namespace Database\Seeders;

use App\Models\Esemeny;
use App\Models\User;
use App\Models\Video;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Video::factory(10)->create();
        Esemeny::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Abcde',
            'regisztracio_datum'=> '2024-09-11',
            'valtozas_datum' => now(),
            'profilkep'=> '',
            'jogosultsagi_szint' => 'felhasznalo',
        ]);

        
        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => 'admin12345',
            'regisztracio_datum'=> '2023-09-11',
            'valtozas_datum' => now(),
            'profilkep'=> '',
            'jogosultsagi_szint' => 'admin',
        ]);


    }
}
