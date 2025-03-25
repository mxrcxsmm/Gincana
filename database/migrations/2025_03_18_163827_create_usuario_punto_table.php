<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuario_punto', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('usuario_id');
            $table->unsignedInteger('punto_id');
            $table->boolean('completado')->default(false);
            $table->timestamp('fecha_completado')->nullable();
            $table->timestamps();

            // Definición de las claves foráneas
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('punto_id')->references('id')->on('puntos_control')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuario_punto');
    }
};
