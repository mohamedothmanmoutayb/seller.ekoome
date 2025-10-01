<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopifyIntegrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopify_integrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_country')->nullable();
            $table->string('last_index', 225)->nullable()->default('0');
            $table->string('id_user')->nullable();
            $table->string('subdomain')->nullable();
            $table->string('api_key')->nullable();
            $table->string('admin_api_access_token')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('shopify_integrations');
    }
}
