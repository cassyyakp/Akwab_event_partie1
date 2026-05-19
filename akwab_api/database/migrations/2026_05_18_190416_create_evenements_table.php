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
        Schema::create('evenements', function (Blueprint $table) {
            $table->id('id_evenement');
            $table->string('nom');
            $table->string('lieu');
            $table->date('date');
            $table->text('description');
            $table->decimal('prix_ticket', 10, 2);
            $table->integer('nombre_ticket_disponible');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('id_categorie');
            $table->foreign('id_categorie')
                ->references('id_categorie')
                ->on('categories')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evenements');
    }
};
