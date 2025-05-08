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
        Schema::create('medicament', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('dose');
            $table->date('date_début');
            $table->date('date_fin');
            $table->foreignId('patientId')->constrained('patient')->onDelete('cascade');
            $table->foreignId('ordonnanceId')->constrained('ordonnance')->onDelete('cascade');
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
        Schema::dropIfExists('medicament');
    }
};
