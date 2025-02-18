<?php

namespace Database\Factories;

use App\Models\Esemeny;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feliratkozas>
 */
class FeliratkozasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'felhasznalo' => User::all()->random()->azonosito,
        	'esemeny' => Esemeny::all()->random()->esemeny_id,
        ];
    }
}
