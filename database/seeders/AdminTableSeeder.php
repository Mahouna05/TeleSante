<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Récupérer les IDs des utilisateurs avec les rôles 'admin' et 'super_admin'
        $adminUsers = DB::table('users')
                          ->whereIn('role', ['admin', 'super_admin'])
                          ->pluck('id');
        
        foreach ($adminUsers as $userId) {
            DB::table('admin')->insert([
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}