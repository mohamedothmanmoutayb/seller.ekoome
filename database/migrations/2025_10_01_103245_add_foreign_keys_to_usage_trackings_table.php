<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUsageTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usage_trackings', function (Blueprint $table) {
            $table->foreign(['user_id'], 'usage_tracking_user_id_foreign')->references(['id'])->on('users')->onDelete('CASCADE');
            $table->foreign(['subscription_id'], 'usage_tracking_subscription_id_foreign')->references(['id'])->on('subscriptions')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usage_trackings', function (Blueprint $table) {
            $table->dropForeign('usage_tracking_user_id_foreign');
            $table->dropForeign('usage_tracking_subscription_id_foreign');
        });
    }
}
