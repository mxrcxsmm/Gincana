<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLugarEtiquetaTable extends Migration
{
    public function up()
    {
        Schema::create('lugar_etiqueta', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lugar_id');
            $table->unsignedInteger('etiqueta_id');

            $table->unique(['lugar_id', 'etiqueta_id']);

            $table->foreign('lugar_id')
                  ->references('id')->on('lugares')
                  ->onDelete('cascade');

            $table->foreign('etiqueta_id')
                  ->references('id')->on('etiquetas')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lugar_etiqueta');
    }
}
