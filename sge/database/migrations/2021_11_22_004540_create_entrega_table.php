<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntregaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrega', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_rastreamento',46)->uniqid('BE')->unique();
            $table->json('dados_pedido');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('rota_atual_id')->nullable();
            $table->date('data_entrada');
            $table->date('previsao_entrega')->nullable();
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
        Schema::dropIfExists('entrega');
    }
}
