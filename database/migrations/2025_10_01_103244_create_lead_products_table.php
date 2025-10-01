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
            $table->string('isupsell', 225)->nullable()->default('0');
            $table->tinyInteger('isupselle_seller')->nullable()->default(0);
            $table->string('id_product')->nullable();
            $table->integer('quantity')->nullable()->default(1);
            $table->string('lead_value')->nullable();
            $table->date('date_delivred')->nullable();
            $table->string('livrison', 225)->default('unpacked');
            $table->boolean('outstock')->nullable()->default(false);
            $table->tinyInteger('outofstock')->nullable()->default(0);
            $table->boolean('isreturn')->nullable()->default(false);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
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
