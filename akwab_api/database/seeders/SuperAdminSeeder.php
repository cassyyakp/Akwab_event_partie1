<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Utilisateur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::where('type', 'Administrateur')->first();
        // dd($role);

        Utilisateur::create([
            'nom'          => 'Admin',
            'prenoms'      => 'Super',
            'email'        => 'admin@akwab.com',
            'telephone'    => '00000000',
            'mot_de_passe' => bcrypt('admin1234'),
            'id_role'      => $role->id_role,
        ]);
    }
}
