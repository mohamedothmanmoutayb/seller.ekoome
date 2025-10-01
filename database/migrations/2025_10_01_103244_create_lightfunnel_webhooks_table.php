<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLightfunnelWebhooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lightfunnel_webhooks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('webhook_event');
            $table->string('url');
            $table->unsignedBigInteger('lightfunnel_store_id')->index('lightfunnel_webhooks_lightfunnel_store_id_foreign');
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
        Schema::dropIfExists('lightfunnel_webhooks');
    }
}
