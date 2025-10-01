<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WhatsappConfirmationNotificationTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_confirmation_notification_templates', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->text('template');
            $table->timestamps();

            $table->unique(['status', 'country_id']);
        });                 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whatsapp_confirmation_notification_templates');
    }
}
