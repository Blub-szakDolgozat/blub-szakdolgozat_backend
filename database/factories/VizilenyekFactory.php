<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vizilenyek>
 */
class VizilenyekFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nev' => fake()->name(),
            'fajta' => fake()->name(),
            'ritkasagi_szint' => fake()->lexify('⭐⭐⭐⭐⭐'),
            'leiras'=>fake()->text(),
            'kep'=>fake()->name(),
        ];
    }
}
