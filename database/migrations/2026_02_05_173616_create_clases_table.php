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
       Schema::create('clases', function (Blueprint $table) {
    $table->id();
    $table->string('nombreClase');
    $table->string('categoria');
    $table->string('diaDeLaSemana');
    $table->time('hora_inicio');
    $table->time('hora_fin');
    $table->unsignedInteger('capacidad_maxima');
    $table->string('estado')->default('activa');
    $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
    $table->date('fecha_desde')->nullable();
    $table->date('fecha_hasta')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clases');
    }
};
