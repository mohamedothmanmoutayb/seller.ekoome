<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYoucanWebhooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('youcan_webhooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('youcan_stores')->onDelete('cascade');
            $table->string('webhook_id');
            $table->string('target_url');
            $table->string('event');
            $table->string('status')->default('INSTALLED');
            $table->timestamps();
            $table->index(['store_id', 'event']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('youcan_webhooks');
    }
}
