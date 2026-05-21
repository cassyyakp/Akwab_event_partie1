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
            $table->id('id_reservation');
            $table->date('date_reservation');
            $table->integer('nombre_ticket_pris');
            $table->decimal('prix_total', 15, 2);
            $table->unsignedBigInteger('id_utilisateurs')->nullable();
            $table->foreign('id_utilisateurs')
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
