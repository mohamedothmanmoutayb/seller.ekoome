<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopifyIntegrationAffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopify_integration_affiliates', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('id_user');
            $table->string('id_country');
            $table->string('last_index')->nullable()->default('0');
            $table->string('subdomain');
            $table->string('api_key');
            $table->string('admin_api_access_token');
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
        Schema::dropIfExists('shopify_integration_affiliates');
    }
}
