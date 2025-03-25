<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritosTable extends Migration
{
    public function up()
    {
        Schema::create('favoritos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_etiqueta', 100);
            $table->unsignedInteger('usuario_id');
            $table->unsignedInteger('lugar_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('usuario_id')
                  ->references('id')->on('usuarios')
                  ->onDelete('cascade');

            $table->foreign('lugar_id')
                  ->references('id')->on('lugares')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('favoritos');
    }
}
