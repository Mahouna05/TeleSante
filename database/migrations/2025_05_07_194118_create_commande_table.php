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
        Schema::create('commande', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patientId')->constrained('patient')->onDelete('cascade');
            $table->foreignId('medicamentId')->constrained('medicament')->onDelete('cascade');
            $table->integer('prix');
            $table->string('indice');
            $table->enum('option', ['standard', 'express']);
            $table->integer('montant_total');
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
        Schema::dropIfExists('commande');
    }
};
