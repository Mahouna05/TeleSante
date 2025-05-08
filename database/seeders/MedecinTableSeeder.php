<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedecinTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Récupérer les IDs des utilisateurs avec le rôle 'medecin'
        $medecinUsers = DB::table('users')
                          ->where('role', 'medecin')
                          ->pluck('id');

        $specialites = [
            'Cardiologie', 'Dermatologie', 'Gastro-entérologie', 
            'Neurologie', 'Pédiatrie', 'Psychiatrie', 'Radiologie',
            'Ophtalmologie', 'Gynécologie', 'Médecine générale'
        ];
        
        foreach ($medecinUsers as $userId) {
            DB::table('medecin')->insert([
                'user_id' => $userId,
                'specialite' => $specialites[array_rand($specialites)],
                'numeroProfessionnel' => 'MED' . rand(10000, 99999),
                'experience' => rand(1, 25) . ' ans',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}