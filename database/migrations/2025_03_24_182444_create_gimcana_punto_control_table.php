<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGimcanaPuntoControlTable extends Migration {
    public function up() {
        Schema::create('gimcana_punto_control', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gimcana_id');
            $table->unsignedInteger('punto_control_id');
            $table->timestamps();

            $table->foreign('gimcana_id')
                  ->references('id')->on('gimcanas')
                  ->onDelete('cascade');

            $table->foreign('punto_control_id')
                  ->references('id')->on('puntos_control')
                  ->onDelete('cascade');
        });
    }
    public function down() {
        Schema::dropIfExists('gimcana_punto_control');
    }
}
