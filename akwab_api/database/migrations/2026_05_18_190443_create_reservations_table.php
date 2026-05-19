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
            $table->decimal('prix_total', 15, 2);
            $table->unsignedBigInteger('id_utilisateur')->nullable();
            $table->foreign('id_utilisateur')
                ->references('id_utilisateurs')
                ->on('utilisateurs')
                ->onDelete('cascade');

            $table->unsignedBigInteger('id_evenement')->nullable();
            $table->foreign('id_evenement')
                ->references('id_evenement')
                ->on('evenements')
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
