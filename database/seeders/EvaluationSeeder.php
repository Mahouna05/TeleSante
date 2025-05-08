<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Récupérer les consultations terminées
        $consultations = DB::table('consultation')
                           ->where('statut', 'terminée')
                           ->get();
        
        $commentaires = [
            'Très bon médecin, à l\'écoute et professionnel',
            'Consultation rapide et efficace',
            'Explications claires sur mon traitement',
            'Médecin compétent mais un peu pressé',
            'Je recommande ce praticien',
            null
        ];
        
        foreach ($consultations as $consultation) {
            // 70% des consultations terminées génèrent une évaluation
            if (rand(1, 10) <= 7) {
                $date = Carbon::parse($consultation->date)->addDays(rand(1, 5));
                
                DB::table('evaluation')->insert([
                    'patientId' => $consultation->patientId,
                    'medecinId' => $consultation->medecinId,
                    'note' => rand(3, 5), // Notes entre 3 et 5
                    'commentaire' => $commentaires[array_rand($commentaires)],
                    'date' => $date,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }
    }
}