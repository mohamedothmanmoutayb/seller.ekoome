<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpeendAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('speend_ads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('country_id')->nullable();
            $table->string('user_id')->nullable();
            $table->integer('id_product_spend')->nullable();
            $table->string('date')->nullable();
            $table->string('amount')->nullable();
            $table->string('note')->nullable();
            $table->string('status')->default('in paid');
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
        Schema::dropIfExists('speend_ads');
    }
}
