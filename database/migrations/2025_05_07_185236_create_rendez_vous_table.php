<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patientId')->constrained('patient')->onDelete('cascade');
            $table->foreignId('medecinId')->constrained('medecin')->onDelete('cascade');
            $table->text('motif');
            $table->enum('moyen', ['vidéo', 'chat', 'audio']);
            $table->timestamp('dateHeure');
            $table->string('tarif');
            $table->enum('statut', ['en attente', 'confirmé', 'annulé']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rendez_vous');
    }
};
