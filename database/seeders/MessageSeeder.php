<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessageSeeder extends Seeder
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
        
        $contenus = [
            'Bonjour docteur, je souhaiterais prendre rendez-vous pour une consultation.',
            'J\'ai une question concernant mon traitement.',
            'Mes symptômes se sont aggravés depuis hier.',
            'Merci pour votre suivi, je me sens beaucoup mieux.',
            'Pourriez-vous me renouveler mon ordonnance ?',
            'Je n\'ai pas pu prendre le médicament prescrit, que dois-je faire ?',
            'Bonjour, quand seront disponibles mes résultats d\'analyse ?'
        ];
        
        // Créer 100 messages
        for ($i = 0; $i < 100; $i++) {
            $dateEnvoi = Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 24));
            $patientId = $patientIds->random();
            $medecinId = $medecinIds->random();
            
            DB::table('message')->insert([
                'senderId' => $patientId,
                'receiverId' => $medecinId,
                'dateEnvoi' => $dateEnvoi,
                'contenu' => $contenus[array_rand($contenus)],
                'created_at' => $dateEnvoi,
                'updated_at' => $dateEnvoi,
            ]);
        }
    }
}