<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentariosYSugerencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios_y_sugerencias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email');
            $table->enum('tipo',['positivo','neutral','negativo']);
            $table->text('comentarios_y_sugerencias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentarios_y_sugerencias');
    }
}
