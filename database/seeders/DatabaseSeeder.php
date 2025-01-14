<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'felhasznalonev' => 'Test User',
            'email' => 'test@example.com',
            'regi_jelszo' => '123456',
            'uj_jelszo' => 'Abcde',
            'regisztracio_datum'=> '2024-09-11',
            'valtozas_datum' => now(),
            'profilkep'=> '',
            'jogosultsagi_szint' => 'felhasznalo',
        ]);

        
        User::factory()->create([
            'felhasznalonev' => 'Test Admin',
            'email' => 'admin@example.com',
            'regi_jelszo' => 'admin1234',
            'uj_jelszo' => 'admin12345',
            'regisztracio_datum'=> '2023-09-11',
            'valtozas_datum' => now(),
            'profilkep'=> '',
            'jogosultsagi_szint' => 'admin',
        ]);


    }
}
