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
        Schema::create('consultation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patientId')->constrained('patient')->onDelete('cascade');
            $table->foreignId('medecinId')->constrained('medecin')->onDelete('cascade');
            $table->timestamp('date');
            $table->enum('type', ['vidéo', 'chat']);
            $table->text('notes')->nullable();
            $table->enum('statut', ['en attente', 'terminée', 'annulée']);
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
        Schema::dropIfExists('consultation');
    }
};
