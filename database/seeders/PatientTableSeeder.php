<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Récupérer les IDs des utilisateurs avec le rôle 'patient'
        $patientUsers = DB::table('users')
                          ->where('role', 'patient')
                          ->pluck('id');

        $groupesSanguins = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $sexes = ['Masculin', 'Feminin'];
        
        foreach ($patientUsers as $userId) {
            $dateNaissance = Carbon::now()->subYears(rand(18, 80))->subDays(rand(0, 365));
            
            DB::table('patient')->insert([
                'user_id' => $userId,
                'dateNaissance' => $dateNaissance,
                'groupeSanguin' => $groupesSanguins[array_rand($groupesSanguins)],
                'taille' => rand(150, 200) . ' cm',
                'poids' => rand(50, 100) . ' kg',
                'profession' => ['Enseignant', 'Ingénieur', 'Médecin', 'Étudiant', 'Retraité', 'Commerçant'][array_rand(['Enseignant', 'Ingénieur', 'Médecin', 'Étudiant', 'Retraité', 'Commerçant'])],
                'sexe' => $sexes[array_rand($sexes)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}