<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Esemeny>
 */
class EsemenyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'esemeny_neve' => fake()->name(),
            'leiras' => fake()->text(),
            'datum' => fake()->date(),
            'helyszin' => fake()->text(),
            'letszam' => rand(100,800)
        ];
    }
}
