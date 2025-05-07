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
        Schema::create('paiement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultationId')->constrained('consultation')->onDelete('cascade');
            $table->foreignId('medecinId')->constrained('medecin')->onDelete('cascade');
            $table->decimal('montant', 8, 2);
            $table->enum('méthode', ['MobileMoney', 'Carte']);
            $table->enum('statut', ['en attente', 'effectué', 'échoué']);
            $table->timestamp('date');
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
        Schema::dropIfExists('paiement');
    }
};
