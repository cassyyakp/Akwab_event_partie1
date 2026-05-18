<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('date_reservation');
            $table->integer('nombre_ticket_pris');
            $table->decimal('prix_total', 10, 2);
            $table->foreignId('id_utilisateur')
                ->constrained('utilisateurs')
                ->onDelete('cascade');
                $table->foreignId('id_evenement')
                ->constrained('evenements')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
