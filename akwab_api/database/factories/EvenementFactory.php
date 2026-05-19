<?php

namespace Database\Factories;

use App\Models\Evenement;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categorie;

/**
 * @extends Factory<Evenement>
 */
class EvenementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom'                      => $this->faker->sentence(3),
            'lieu'                     => $this->faker->city(),
            'date'                     => $this->faker->dateTimeBetween('now', '+6 months'),
            'description'              => $this->faker->paragraph(),
            'prix_ticket'              => $this->faker->randomFloat(2, 1000, 50000),
            'nombre_ticket_disponible' => $this->faker->numberBetween(10, 500),
            'image'                    => null,
            'id_categorie'             => Categorie::inRandomOrder()->first()->id_categorie,
        ];
    }
}
