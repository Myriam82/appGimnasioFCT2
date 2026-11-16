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
        Schema::create('clase_reservas', function (Blueprint $table) {
            $table->id();
            // Asi se asigna un monitor a una clase
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Asi no se asigna un monitor a una clase
            //$table->foreignId('user_id')->nullable()->constrained();
            //$table->foreignId('clase_id')->constrained('clases');
            //Borrar automaticamente las reservas al borrar la clase
            $table->foreignId('clase_id')
                ->references('id')->on('clases')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clases_reservas');
    }
};
