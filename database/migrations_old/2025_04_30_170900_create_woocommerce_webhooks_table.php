<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWoocommerceWebhooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('woocommerce_webhooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('integration_id')->constrained('woocommerce_integrations')->onDelete('cascade');
            $table->string('webhook_id')->nullable();
            $table->string('topic')->default('order.created');
            $table->string('status')->default('active');
            $table->string('secret')->nullable();
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
        Schema::dropIfExists('woocommerce_webhooks');
    }
}
