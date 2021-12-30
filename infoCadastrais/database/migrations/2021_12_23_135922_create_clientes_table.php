<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome',255);
            $table->string('razao_social',255)->nullable();
            $table->enum('sexo',['M','F'])->nullable();
            $table->date('data_nascimento')->nullable();
            $table->enum('tp_pessoa',['F','J']);
            $table->string('cpfOuCnpj',14)->unique();
            $table->string('email',150)->unique();
            $table->string('telefone',20)->nullable();
            $table->string('logradouro',400)->nullable();
            $table->string('numero',40)->nullable();
            $table->string('complemento',140)->nullable();
            $table->string('bairro',140)->nullable();
            $table->string('cidade',140)->nullable();
            $table->string('uf',2)->nullable();
            $table->string('cep',8)->nullable();
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
        Schema::dropIfExists('clientes');
    }
}
