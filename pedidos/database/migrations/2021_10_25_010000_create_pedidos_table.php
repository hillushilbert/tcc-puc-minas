<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Adresses
        Schema::create('adresses', function (Blueprint $table) {
            $table->id();
            $table->string('street',255);
            $table->smallInteger('number')->nullable();
            $table->string('city',255)->nullable();
            $table->string('state',255)->nullable();
            $table->string('country',255)->nullable();
            $table->smallInteger('active')->default(1);
            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('email',255)->unique();
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->date('birth_date')->nullable();
            $table->string('email',255)->unique();
            $table->timestamps();
        });


        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('origin_adress_id');
            $table->unsignedBigInteger('destination_adress_id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('unity',20);
            $table->decimal('weight',11,5);
            $table->smallInteger('height');
            $table->smallInteger('width');
            $table->smallInteger('length');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
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
        Schema::dropIfExists('orders');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('adresses');
    }
}
