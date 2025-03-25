<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->string('email', 150)->unique();
            $table->string('password', 255);
            $table->unsignedInteger('role_id')->default(2); // 1 = admin, 2 = usuario
            $table->unsignedInteger('grupo_id')->nullable();
            $table->timestamps();
            
            $table->foreign('role_id')
                  ->references('id')->on('roles')
                  ->onDelete('restrict');
            
            $table->foreign('grupo_id')
                ->references('id')->on('grupos')
                ->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
