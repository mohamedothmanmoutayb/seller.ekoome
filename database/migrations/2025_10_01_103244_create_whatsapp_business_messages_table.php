<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappBusinessMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_business_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('whats_app_conversation_id');
            $table->string('message_id');
            $table->string('from');
            $table->string('to');
            $table->text('body')->nullable();
            $table->enum('direction', ['in', 'out']);
            $table->string('type')->default('message');
            $table->string('template_name')->nullable();
            $table->json('template_data')->nullable();
            $table->enum('status', ['sent', 'delivered', 'read', 'failed', 'received'])->default('sent');
            $table->json('error_data')->nullable();
            $table->boolean('read')->default(false);
            $table->string('quoted_message_id')->nullable();
            $table->tinyInteger('deleted')->default(0);
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
        Schema::dropIfExists('whatsapp_business_messages');
    }
}
