<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Récupérer tous les IDs de patients et médecins
        $patientIds = DB::table('patient')->pluck('id');
        $medecinIds = DB::table('medecin')->pluck('id');
        
        $statuts = ['en attente', 'terminée', 'annulée'];
        $types = ['vidéo', 'chat'];
        $notes = [
            'Le patient présente des symptômes de rhume', 
            'Renouvellement d\'ordonnance effectué',
            'Consultation de suivi après traitement',
            'Première consultation pour diagnostic',
            null
        ];
        
        // Créer 50 consultations
        for ($i = 0; $i < 50; $i++) {
            $date = Carbon::now()->subDays(rand(0, 60));
            $patientId = $patientIds->random();
            $medecinId = $medecinIds->random();
            $statut = $statuts[array_rand($statuts)];
            
            DB::table('consultation')->insert([
                'patientId' => $patientId,
                'medecinId' => $medecinId,
                'date' => $date,
                'type' => $types[array_rand($types)],
                'notes' => $notes[array_rand($notes)],
                'statut' => $statut,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}