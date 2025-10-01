<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToLightfunnelWebhooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lightfunnel_webhooks', function (Blueprint $table) {
            $table->foreign(['lightfunnel_store_id'])->references(['id'])->on('lightfunnel_stores')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lightfunnel_webhooks', function (Blueprint $table) {
            $table->dropForeign('lightfunnel_webhooks_lightfunnel_store_id_foreign');
        });
    }
}
