<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Départements
        Schema::create('departements', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->timestamps();
        });

        // Communes
        Schema::create('communes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->foreignId('departement_id')->constrained()->onDelete('cascade');
            $table->unique(['nom', 'departement_id']);
            $table->timestamps();
        });

        // Arrondissements
        Schema::create('arrondissements', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->foreignId('commune_id')->constrained()->onDelete('cascade');
            $table->unique(['nom', 'commune_id']);
            $table->timestamps();
        });

        // Quartiers
        Schema::create('quartiers', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->foreignId('arrondissement_id')->constrained()->onDelete('cascade');
            $table->unique(['nom', 'arrondissement_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quartiers');
        Schema::dropIfExists('arrondissements');
        Schema::dropIfExists('communes');
        Schema::dropIfExists('departements');
    }
};