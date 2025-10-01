<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopifyIntegrationV2STable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopify_integration_v2_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_country');
            $table->string('last_index')->default('0');
            $table->string('id_user');
            $table->string('subdomain');
            $table->string('api_key');
            $table->string('admin_api_access_token');
            $table->string('status')->default('1');
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
        Schema::dropIfExists('shopify_integration_v2_s');
    }
}
