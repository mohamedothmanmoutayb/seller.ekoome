<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopifyStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopify_stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('store_name')->nullable();
            $table->string('shopify_domain')->nullable();
            $table->string('user_id')->nullable();
            $table->string('id_country');
            $table->string('api_key')->nullable();
            $table->string('admin_api_access_token')->nullable();
            $table->string('api_version');
            $table->string('webhook_id')->nullable();
            $table->boolean('is_active')->nullable();
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
        Schema::dropIfExists('shopify_stores');
    }
}
