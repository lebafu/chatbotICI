<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NluName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('nlu_name', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->foreignId('id_archivo_nlu')->references('id')->on('archivo_nlu');
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
        Schema::dropIfExists('nlu_name');

    }
}
