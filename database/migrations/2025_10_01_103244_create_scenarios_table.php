<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScenariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scenarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_campaigne');
            $table->double('price_sale');
            $table->integer('totalLeads')->nullable();
            $table->double('confirmation_rate', 8, 2);
            $table->double('delivery_rate', 8, 2);
            $table->double('fees')->nullable();
            $table->double('profit')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('scenarios');
    }
}
