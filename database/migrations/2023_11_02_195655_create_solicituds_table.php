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
        Schema::create('solicituds', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('ci');
            $table->string('celular');
            $table->string('email')->nullable();
            $table->string('direccion');
            $table->string('estado');
            
            $table->unsignedBigInteger('zona_id')->nullable();
            $table->foreign('zona_id')->references('id')->on('zonas')->onDelete('cascade');
            
            $table->unsignedBigInteger('plan_internet_id');
            $table->foreign('plan_internet_id')->references('id')->on('plan_internets')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicituds');
    }
};
