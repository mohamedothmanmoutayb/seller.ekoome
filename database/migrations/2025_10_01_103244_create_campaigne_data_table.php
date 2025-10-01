<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaigneDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigne_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_product');
            $table->integer('id_country')->nullable();
            $table->double('price_sale');
            $table->double('cost_ad');
            $table->double('cost_product');
            $table->double('confirmation_rate', 8, 2);
            $table->double('delivery_rate', 8, 2);
            $table->double('fees')->nullable();
            $table->integer('quantity');
            $table->integer('totalLeads')->nullable();
            $table->double('result')->nullable();
            $table->integer('totalLeadsNeeded')->nullable();
            $table->string('id_client');
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
        Schema::dropIfExists('campaigne_data');
    }
}
