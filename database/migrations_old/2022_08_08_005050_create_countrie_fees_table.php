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
            $table->string('fees_confirmation')->nullable();
            $table->string('fess_shipping')->nullable();
            $table->string('percentage')->nullable();
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
