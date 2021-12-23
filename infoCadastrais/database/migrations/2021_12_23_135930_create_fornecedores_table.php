<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFornecedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->string('razao_social',255)->nullable();
            $table->string('cnpj',14)->unique();
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
        Schema::dropIfExists('fornecedores');
    }
}
