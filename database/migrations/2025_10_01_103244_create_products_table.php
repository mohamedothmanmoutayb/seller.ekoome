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
            $table->string('id_store', 225)->nullable();
            $table->string('id_category')->nullable();
            $table->string('id_subcategory')->nullable();
            $table->string('id_user')->nullable();
            $table->string('type')->default('seller');
            $table->string('sku')->nullable();
            $table->string('name')->nullable();
            $table->string('price')->nullable();
            $table->double('price_service')->nullable();
            $table->double('price_vente')->nullable();
            $table->double('offer_price')->nullable();
            $table->tinyInteger('is_fixed_price')->nullable()->default(0);
            $table->double('price_fixed')->nullable();
            $table->text('link')->nullable();
            $table->text('link_video')->nullable();
            $table->string('quantity_real')->nullable()->default('11');
            $table->string('low_stock')->nullable();
            $table->integer('id_country');
            $table->string('warehouse_id', 225)->nullable();
            $table->string('image', 500)->nullable();
            $table->text('description')->nullable();
            $table->string('weight', 225)->nullable();
            $table->tinyInteger('checkimport')->nullable()->default(0);
            $table->string('status')->nullable()->default('inactive');
            $table->timestamps();
            $table->softDeletes();
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
