<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RendezVousSeeder extends Seeder
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
        
        $motifs = [
            'Consultation de routine', 'Suivi de traitement', 
            'Nouveaux symptômes', 'Renouvellement d\'ordonnance',
            'Douleurs abdominales', 'Maux de tête persistants'
        ];
        
        $moyens = ['vidéo', 'chat', 'audio'];
        $statuts = ['en attente', 'confirmé', 'annulé'];
        $tarifs = ['30€', '45€', '50€', '60€', '75€'];
        
        // Créer 30 rendez-vous
        for ($i = 0; $i < 30; $i++) {
            $dateHeure = Carbon::now()->addDays(rand(1, 30))->addHours(rand(8, 17));
            $patientId = $patientIds->random();
            $medecinId = $medecinIds->random();
            
            DB::table('rendez_vous')->insert([
                'patientId' => $patientId,
                'medecinId' => $medecinId,
                'motif' => $motifs[array_rand($motifs)],
                'moyen' => $moyens[array_rand($moyens)],
                'dateHeure' => $dateHeure,
                'tarif' => $tarifs[array_rand($tarifs)],
                'statut' => $statuts[array_rand($statuts)],
                'created_at' => Carbon::now()->subDays(rand(1, 10)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}