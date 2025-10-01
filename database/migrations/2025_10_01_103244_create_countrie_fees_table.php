<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountrieFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countrie_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_country')->nullable();
            $table->string('id_user')->nullable();
            $table->string('entred_fees')->nullable();
            $table->string('fees_confirmation')->nullable()->default('0');
            $table->string('delivered_fees')->nullable();
            $table->string('upsell')->nullable();
            $table->string('delivered_shipping')->nullable();
            $table->string('returned_shipping')->nullable();
            $table->string('fullfilment')->nullable();
            $table->integer('vat')->nullable()->default(0);
            $table->string('percentage')->nullable()->default('2');
            $table->string('cod_fixed')->default('0.9');
            $table->string('island_shipping', 225)->nullable();
            $table->string('island_return', 225)->nullable();
            $table->string('return_management', 225)->nullable();
            $table->string('shipping_menor_island')->nullable();
            $table->string('return_menor_island')->nullable();
            $table->string('extra_kilog')->default('0.5');
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
        Schema::dropIfExists('countrie_fees');
    }
}
