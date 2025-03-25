<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuntosControlTable extends Migration
{
    public function up()
    {
        Schema::create('puntos_control', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lugar_id');
            $table->text('descripcion');
            $table->text('pista');
            $table->text('prueba');
            $table->timestamps();

            $table->foreign('lugar_id')
                  ->references('id')->on('lugares')
                  ->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('puntos_control');
    }
}
