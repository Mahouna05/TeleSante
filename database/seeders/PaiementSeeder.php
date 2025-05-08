<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaiementSeeder extends Seeder
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
        
        $methodes = ['MobileMoney', 'Carte'];
        $statuts = ['en attente', 'effectué', 'échoué'];
        
        foreach ($consultations as $consultation) {
            // Générer un montant entre 30 et 100 €
            $montant = rand(30, 100);
            
            DB::table('paiement')->insert([
                'consultationId' => $consultation->id,
                'medecinId' => $consultation->medecinId,
                'patientId' => $consultation->patientId,
                'montant' => $montant,
                'méthode' => $methodes[array_rand($methodes)],
                'statut' => $statuts[array_rand($statuts)],
                'date' => Carbon::parse($consultation->date)->addMinutes(rand(30, 60)),
                'created_at' => Carbon::parse($consultation->date)->addMinutes(rand(30, 60)),
                'updated_at' => Carbon::parse($consultation->date)->addMinutes(rand(30, 60)),
            ]);
        }
    }
}