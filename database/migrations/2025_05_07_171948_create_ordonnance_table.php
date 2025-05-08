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
        Schema::create('ordonnance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultationId')->constrained('consultation')->onDelete('cascade');
            $table->foreignId('patientId')->constrained('patient')->onDelete('cascade');
            $table->foreignId('medecinId')->constrained('medecin')->onDelete('cascade');
            $table->string('medicament');
            $table->string('dose');
            $table->string('durée');
            $table->text('instructions');
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
        Schema::dropIfExists('ordonnance');
    }
};
