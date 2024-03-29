<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Answer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('answer', function (Blueprint $table) {
            $table->id();
            $table->text('nombre');
            $table->string('vence')->nullable();
            $table->date('fecha_caducacion')->nullable();
            //$table->foreignId('id_archivo')->references('id')->on('archivo_qna');
            $table->foreignId('id_categoria')->references('id')->on('categorias')->default('1');
            $table->string('contexto');
            $table->string('archivo_qna');
            $table->integer('habilitada');
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
        Schema::dropIfExists('answer');

    }
}
