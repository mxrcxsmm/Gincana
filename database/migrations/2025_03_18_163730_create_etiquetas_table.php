<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtiquetasTable extends Migration
{
    public function up()
    {
        Schema::create('etiquetas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->string('color', 7);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('etiquetas');
    }
}
