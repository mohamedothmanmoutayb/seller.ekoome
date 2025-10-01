<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsageTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usage_trackings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('usage_tracking_user_id_index');
            $table->unsignedBigInteger('subscription_id')->index('usage_tracking_subscription_id_index');
            $table->string('metric')->index('usage_tracking_metric_index');
            $table->integer('current_usage')->default(0);
            $table->integer('limit')->default(0);
            $table->date('period_start');
            $table->date('period_end');
            $table->timestamps();

            $table->index(['period_start', 'period_end'], 'usage_tracking_period_start_period_end_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usage_trackings');
    }
}
