<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Désactiver les contraintes de clés étrangères pendant le seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        $this->call([
            UsersTableSeeder::class,
            PatientTableSeeder::class,
            MedecinTableSeeder::class,
            AdminTableSeeder::class,
            DossierMedicalSeeder::class,
            ConsultationSeeder::class,
            OrdonnanceSeeder::class,
            MedicamentSeeder::class,
            RendezVousSeeder::class,
            PaiementSeeder::class,
            MessageSeeder::class,
            NotificationSeeder::class,
            EvaluationSeeder::class,
            CommandeSeeder::class,
        ]);
        
        // Réactiver les contraintes de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}