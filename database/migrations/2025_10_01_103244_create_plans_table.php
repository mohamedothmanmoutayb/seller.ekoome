<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('external_client_id')->index();
            $table->unsignedBigInteger('external_plan_id')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('monthly_price', 10);
            $table->decimal('yearly_price', 10);
            $table->decimal('monthly_price_before_discount', 10)->default(0);
            $table->decimal('yearly_price_before_discount', 10)->default(0);
            $table->string('users')->default('0');
            $table->string('max_monthly_sales')->default('0');
            $table->string('shipping_companies')->default('0');
            $table->string('deliverymen')->default('0');
            $table->string('stores')->default('0');
            $table->string('agents')->default('0');
            $table->string('sales_channels')->default('0');
            $table->string('products')->default('0');
            $table->boolean('is_active')->default(true)->index();
            $table->enum('type', ['individual', 'company'])->default('individual')->index();
            $table->timestamps();

            $table->index(['external_client_id', 'external_plan_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
