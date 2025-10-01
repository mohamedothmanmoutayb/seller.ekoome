<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('whatsapp_registered_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_account_id')->constrained('whatsapp_business_accounts')->cascadeOnDelete();
            $table->string('phone_number_id')->unique();
            $table->string('phone_number')->unique();
            $table->string('display_phone_number')->nullable();
            $table->string('quality_rating')->nullable();
            $table->string('status')->default('pending');
            $table->text('certificate')->nullable();
            $table->json('meta_data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('whatsapp_registered_numbers');
    }
};  