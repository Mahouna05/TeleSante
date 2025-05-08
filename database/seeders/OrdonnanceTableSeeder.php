<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdonnanceSeeder extends Seeder
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
        
        $medicaments = [
            'Paracétamol', 'Ibuprofène', 'Amoxicilline', 
            'Doliprane', 'Spasfon', 'Ventoline', 'Levothyrox'
        ];
        
        $doses = [
            '500mg', '1g', '250mg', '50mg', '100mg', '2mg'
        ];
        
        $durees = [
            '5 jours', '7 jours', '10 jours', '2 semaines', '1 mois', '3 mois'
        ];
        
        $instructions = [
            'Prendre 1 comprimé 3 fois par jour avant les repas',
            'Prendre 1 comprimé matin et soir',
            'Prendre 1 comprimé au coucher',
            'Prendre 1 comprimé uniquement en cas de douleur, maximum 3 par jour',
            'Prendre 1 comprimé à jeun le matin'
        ];
        
        foreach ($consultations as $consultation) {
            if (rand(0, 1)) { // 50% des consultations génèrent une ordonnance
                DB::table('ordonnance')->insert([
                    'consultationId' => $consultation->id,
                    'patientId' => $consultation->patientId,
                    'medecinId' => $consultation->medecinId,
                    'medicament' => $medicaments[array_rand($medicaments)],
                    'dose' => $doses[array_rand($doses)],
                    'durée' => $durees[array_rand($durees)],
                    'instructions' => $instructions[array_rand($instructions)],
                    'created_at' => $consultation->date,
                    'updated_at' => $consultation->date,
                ]);
            }
        }
    }
}