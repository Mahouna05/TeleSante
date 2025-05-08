<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Créer un super_admin
        DB::table('users')->insert([
            'name' => 'Admin',
            'firstname' => 'Super',
            'email' => 'super_admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'nomUtilisateur' => 'super_admin',
            'role' => 'super_admin',
            'adresse' => '123 Admin Street',
            'tel' => '0123456789',
            'statut' => 'actif',
            'dateCreation' => now(),
            'created_at' => now(),
            'updated_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // Créer 5 utilisateurs admin
        for ($i = 1; $i <= 5; $i++) {
            DB::table('users')->insert([
                'name' => 'Admin' . $i,
                'firstname' => 'User' . $i,
                'email' => 'admin' . $i . '@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'nomUtilisateur' => 'admin_user' . $i,
                'role' => 'admin',
                'adresse' => $i . ' Admin Avenue',
                'tel' => '01234' . sprintf('%05d', $i),
                'statut' => 'actif',
                'dateCreation' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }

        // Créer 10 utilisateurs médecins
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'name' => 'Docteur' . $i,
                'firstname' => 'Med' . $i,
                'email' => 'medecin' . $i . '@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'nomUtilisateur' => 'doc_' . $i,
                'role' => 'medecin',
                'adresse' => $i . ' Médical Boulevard',
                'tel' => '02345' . sprintf('%05d', $i),
                'statut' => 'actif',
                'dateCreation' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }

        // Créer 30 utilisateurs patients
        for ($i = 1; $i <= 30; $i++) {
            DB::table('users')->insert([
                'name' => 'Patient' . $i,
                'firstname' => 'User' . $i,
                'email' => 'patient' . $i . '@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'nomUtilisateur' => 'patient_' . $i,
                'role' => 'patient',
                'adresse' => $i . ' Patient Street',
                'tel' => '03456' . sprintf('%05d', $i),
                'statut' => 'actif',
                'dateCreation' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}