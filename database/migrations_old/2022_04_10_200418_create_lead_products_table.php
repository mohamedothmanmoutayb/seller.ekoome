<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_lead')->nullable();
            $table->string('isupsell')->nullable();
            $table->string('id_product')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('lead_value')->nullable();
            $table->date('date_delivred')->nullable();
            $table->string('livrison')->default("unpacked");
            $table->boolean('outstock')->default('0');
            $table->boolean('outofstock')->default('0');
            $table->boolean('isreturn')->default('0');
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
        Schema::dropIfExists('lead_products');
    }
}
