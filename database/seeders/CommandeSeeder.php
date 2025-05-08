<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Récupérer tous les IDs de patients et médicaments
        $patientIds = DB::table('patient')->pluck('id');
        $medicamentIds = DB::table('medicament')->pluck('id');
        
        // Si aucun médicament n'a été créé, on ne peut pas créer de commandes
        if ($medicamentIds->isEmpty()) {
            return;
        }
        
        $options = ['standard', 'express'];
        $indices = ['Pharmacie A', 'Pharmacie B', 'Pharmacie C', 'Service de livraison'];
        
        // Créer 20 commandes
        for ($i = 0; $i < 20; $i++) {
            $patientId = $patientIds->random();
            $medicamentId = $medicamentIds->random();
            $prix = rand(10, 50);
            $option = $options[array_rand($options)];
            
            // Calculer le montant total (prix + frais de livraison si express)
            $montantTotal = $prix + ($option == 'express' ? 10 : 0);
            
            DB::table('commande')->insert([
                'patientId' => $patientId,
                'medicamentId' => $medicamentId,
                'prix' => $prix,
                'indice' => $indices[array_rand($indices)],
                'option' => $option,
                'montant_total' => $montantTotal,
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => Carbon::now()->subDays(rand(0, 10)),
            ]);
        }
    }
}