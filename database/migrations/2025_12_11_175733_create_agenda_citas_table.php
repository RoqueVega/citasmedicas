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
        Schema::create('agenda_citas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('medico_id');
            $table->unsignedBigInteger('profesion_id');
            $table->datetime('fecha_reservacion');
            $table->text('motivo_visita')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->foreign('medico_id')->references('id')->on('medicos');
            $table->foreign('profesion_id')->references('id')->on('profesiones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda_citas');
    }
};
