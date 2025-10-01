<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('language')->nullable();
            $table->string('flag', 225)->nullable();
            $table->string('frais_confirmation')->nullable();
            $table->string('frais_delivery')->nullable();
            $table->string('fees_wearhouse')->nullable();
            $table->string('fees_router')->nullable();
            $table->string('frais_delivery_man')->nullable();
            $table->string('type_per')->default('1');
            $table->string('fees')->nullable();
            $table->string('negative', 225)->nullable();
            $table->string('negative_ultra')->nullable();
            $table->string('currency', 225)->nullable();
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
        Schema::dropIfExists('countries');
    }
}
