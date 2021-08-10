<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PreguntasSinRespuestas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('preguntas_sin_respuestas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email');
            $table->text('pregunta_sin_respuesta');
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
        //
        Schema::dropIfExists('preguntas_sin_respuestas');
    }
}
