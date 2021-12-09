<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodigoRastreioToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->string('codigo_rastreamento',30)->nullable();
        });

        Schema::table('customers', function (Blueprint $table) {
            //
            $table->string('cpf',11)->nullable();
        });

        Schema::table('adresses', function (Blueprint $table) {
            //
            $table->string('zipcode',8)->nullable();
            $table->string('neighborhood',30)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->dropColumn('codigo_rastreamento');
        });

        Schema::table('customers', function (Blueprint $table) {
            //
            $table->dropColumn('cpf');
        });

        Schema::table('adresses', function (Blueprint $table) {
            //
            $table->dropColumn('zipcode');
            $table->dropColumn('neighborhood');
        });
    }
}
