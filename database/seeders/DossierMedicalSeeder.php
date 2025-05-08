<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DossierMedicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Récupérer tous les IDs de patients
        $patientIds = DB::table('patient')->pluck('id');
        
        $antecedents = [
            'Diabète de type 2', 'Hypertension artérielle', 'Asthme', 
            'Aucun antécédent chronique', 'Insuffisance cardiaque', 'Arthrose'
        ];
        
        $allergies = [
            'Pénicilline', 'Arachides', 'Gluten', 'Lactose',
            'Aucune allergie connue', 'Poussière', 'Pollen', 'Fruits de mer'
        ];
        
        $pathologies = [
            'Aucune pathologie connue', 'Dépression', 'Migraine chronique',
            'Hypercholestérolémie', 'Hypothyroïdie', 'Ostéoporose'
        ];
        
        $vaccinations = [
            'À jour selon le calendrier vaccinal', 'Dernier rappel tétanos en 2020',
            'Vaccination COVID-19 complète', 'Vaccination contre la grippe annuelle'
        ];
        
        foreach ($patientIds as $patientId) {
            DB::table('dossier_medical')->insert([
                'patientId' => $patientId,
                'antécédents_chroniques' => $antecedents[array_rand($antecedents)],
                'allergies' => $allergies[array_rand($allergies)],
                'pathologies' => $pathologies[array_rand($pathologies)],
                'vaccinations' => $vaccinations[array_rand($vaccinations)],
                'symptomes_decrits' => rand(0, 1) ? 'Fatigue, maux de tête occasionnels' : null,
                'resultats_examens' => rand(0, 1) ? 'Taux de cholestérol légèrement élevé' : null,
                'traitements' => rand(0, 1) ? 'Aucun traitement en cours' : null,
                'medicaments_prescrits' => rand(0, 1) ? 'Paracétamol en cas de douleur' : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}