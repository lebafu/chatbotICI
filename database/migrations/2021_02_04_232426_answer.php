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
            $table->string('vence')->default('No');
            $table->date('fecha_caducacion')->nullable();
            //$table->foreignId('id_archivo')->references('id')->on('archivo_qna');
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
