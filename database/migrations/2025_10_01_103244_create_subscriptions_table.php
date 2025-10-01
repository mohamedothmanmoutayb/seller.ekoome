<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('user_foreign_key_index');
            $table->unsignedBigInteger('external_client_id')->index();
            $table->unsignedBigInteger('external_plan_id');
            $table->string('plan_name');
            $table->decimal('total_price', 10);
            $table->decimal('discount', 10)->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('payment_type', ['monthly', 'yearly']);
            $table->boolean('is_active')->default(true)->index();
            $table->string('external_subscriber_id')->index();
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
        Schema::dropIfExists('subscriptions');
    }
}
