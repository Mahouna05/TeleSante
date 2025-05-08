<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Correction: La table est 'users' et non 'user'
        $userIds = DB::table('users')->pluck('id');
        
        $types = ['rappel', 'alerte', 'info'];
        
        $messages = [
            'Rappel de votre rendez-vous demain à 14h00',
            'Votre ordonnance expire dans 3 jours',
            'Nouveaux résultats disponibles dans votre dossier médical',
            'Un médecin a répondu à votre message',
            'Votre paiement a été confirmé',
            'Mise à jour des conditions d\'utilisation',
            'Nouveau médecin disponible dans votre spécialité'
        ];
        
        // Créer 50 notifications
        for ($i = 0; $i < 50; $i++) {
            $userId = $userIds->random();
            $lu = (bool)rand(0, 1);
            $createdAt = Carbon::now()->subDays(rand(0, 14));
            
            DB::table('notification')->insert([
                'userId' => $userId,
                'type' => $types[array_rand($types)],
                'message' => $messages[array_rand($messages)],
                'lu' => $lu,
                'created_at' => $createdAt,
                'updated_at' => $lu ? $createdAt->copy()->addHours(rand(1, 24)) : $createdAt,
            ]);
        }
    }
}