<?php

namespace Database\Factories;

use App\Models\Evenement;
use App\Models\Reservation;
use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_reservation' => fake()->date(),
            'nombre_ticket_pris' => fake()->numberBetween(1, 10),
            'prix_total' => fake()->randomFloat(2, 1000, 50000),
            'id_utilisateurs' => Utilisateur::factory(),
            'id_evenement' => Evenement::factory(),
        ];
    }
}
