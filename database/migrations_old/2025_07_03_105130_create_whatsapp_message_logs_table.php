<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('whatsapp_message_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registered_number_id')->constrained('whatsapp_registered_numbers')->cascadeOnDelete();
            $table->foreignId('business_account_id')->constrained('whatsapp_business_accounts')->cascadeOnDelete();
            $table->string('message_id')->nullable();
            $table->enum('direction', ['inbound', 'outbound']);
            $table->string('from');
            $table->string('to');
            $table->text('content');
            $table->string('content_type');
            $table->string('status')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->json('meta_data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('whatsapp_message_logs');
    }
};