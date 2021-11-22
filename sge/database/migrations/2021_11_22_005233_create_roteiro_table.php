<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoteiroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roteiro', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entrega_id');
            $table->unsignedBigInteger('roteiro_anterior_id')->nullable();
            $table->unsignedBigInteger('roteiro_proximo_id')->nullable();
            $table->string('de',400);
            $table->unsignedBigInteger('de_cd_id')->nullable();
            $table->string('para',400);
            $table->unsignedBigInteger('para_cd_id')->nullable();
            $table->smallInteger('iniciado')->default(0);
            $table->smallInteger('concluido')->default(0);
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
        Schema::dropIfExists('roteiro');
    }
}
