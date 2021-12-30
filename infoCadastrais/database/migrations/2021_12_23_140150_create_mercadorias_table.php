<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMercadoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mercadorias', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->string('codigo_rastreamento')->unique();
            $table->unsignedBigInteger('id_deposito');
            $table->unsignedBigInteger('id_cliente');
            $table->decimal('valor_declarado',11,2);
            $table->foreign('id_deposito')->references('id')->on('depositos');
            $table->foreign('id_cliente')->references('id')->on('clientes');
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
        Schema::dropIfExists('mercadorias');
    }
}
