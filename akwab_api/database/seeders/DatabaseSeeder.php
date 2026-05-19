<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Categorie;
use App\Models\Utilisateur;
use App\Models\Evenement;
use App\Models\Reservation;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['type' => 'Administrateur']);
        Role::create(['type' => 'Utilisateur']);
        Categorie::factory(5)->create();
        $this->call(SuperAdminSeeder::class);
        Utilisateur::factory(10)->create();
        Evenement::factory(10)->create();
        Reservation::factory(10)->create();
    }
}
