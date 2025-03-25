<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGimcanasTable extends Migration
{
    public function up()
    {
        Schema::create('gimcanas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            // Puedes agregar otros campos que necesites, como fecha inicio, estado, etc.
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gimcanas');
    }
}
