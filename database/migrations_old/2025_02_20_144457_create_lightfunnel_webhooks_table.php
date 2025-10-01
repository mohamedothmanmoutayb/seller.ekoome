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
            $table->id();
            $table->string('webhook_event');
            $table->string('url');
            $table->foreignId('lightfunnel_store_id')->constrained('lightfunnel_stores')->onDelete('cascade');
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
