<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_client_id'); 
            $table->unsignedBigInteger('external_plan_id');   
            $table->string('plan_name');
            $table->decimal('total_price', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('payment_type', ['monthly', 'yearly']);
            $table->boolean('is_active')->default(true);
            $table->string('external_subscriber_id'); 
            $table->timestamps();
            
            $table->index('external_client_id');
            $table->index('external_subscriber_id');
            $table->index('is_active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};