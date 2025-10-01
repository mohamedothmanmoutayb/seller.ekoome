<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_user')->nullable();
            $table->string('sku')->nullable();
            $table->string('name')->nullable();
            $table->string('price')->nullable();
            $table->text('link')->nullable();
            $table->text('link_video')->nullable();
            $table->string('quantity_real')->nullable();
            $table->string('low_stock')->nullable();
            $table->string('id_country')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('products');
    }
}
