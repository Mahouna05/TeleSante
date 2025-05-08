<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MedicamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Récupérer toutes les ordonnances
        $ordonnances = DB::table('ordonnance')->get();
        
        $medicaments = [
            'Paracétamol', 'Ibuprofène', 'Amoxicilline', 
            'Doliprane', 'Spasfon', 'Ventoline', 'Levothyrox'
        ];
        
        $doses = [
            '500mg', '1g', '250mg', '50mg', '100mg', '2mg'
        ];
        
        foreach ($ordonnances as $ordonnance) {
            $dateDebut = Carbon::parse($ordonnance->created_at);
            $dateFin = Carbon::parse($dateDebut)->addDays(rand(7, 90));
            
            // Ajouter 1-3 médicaments par ordonnance
            $nbMedicaments = rand(1, 3);
            
            for ($i = 0; $i < $nbMedicaments; $i++) {
                DB::table('medicament')->insert([
                    'name' => $medicaments[array_rand($medicaments)],
                    'dose' => $doses[array_rand($doses)],
                    'date_début' => $dateDebut,
                    'date_fin' => $dateFin,
                    'patientId' => $ordonnance->patientId,
                    'ordonnanceId' => $ordonnance->id,
                    'created_at' => $dateDebut,
                    'updated_at' => $dateDebut,
                ]);
            }
        }
    }
}