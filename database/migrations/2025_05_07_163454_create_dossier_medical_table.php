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
        Schema::create('dossier_medical', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patientId')->constrained('patient')->onDelete('cascade');
            $table->text('antécédents_chroniques')->nullable();
            $table->text('allergies')->nullable();
            $table->text('pathologies')->nullable();
            $table->text('vaccinations')->nullable();
            $table->text('symptomes_decrits')->nullable();
            $table->text('resultats_examens')->nullable();
            $table->text('traitements')->nullable();
            $table->text('medicaments_prescrits')->nullable();
            $table->timestamp('dateCréation')->useCurrent();
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
        Schema::dropIfExists('dossier_medical');
    }
};
