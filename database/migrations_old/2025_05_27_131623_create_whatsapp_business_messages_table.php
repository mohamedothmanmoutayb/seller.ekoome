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
            $table->id();
            $table->foreignId('conversation_id')
                ->constrained('whatsapp_conversations')
                ->onDelete('cascade');
            $table->foreignId('whatsapp_business_account_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('message_id')->index();
            $table->string('from');
            $table->string('to');
            $table->text('body')->nullable();
            $table->enum('direction', ['in', 'out']);
            $table->enum('status', ['sent', 'delivered', 'read', 'failed'])
                ->default('sent');
            $table->boolean('read')->default(false);
            $table->timestamps();

            $table->unique(['whatsapp_business_account_id', 'message_id']);
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
