<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappConfirmationTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_confirmation_templates', function (Blueprint $table) {
            $table->id();
            $table->string('status'); 
            $table->string('language'); 
            $table->text('template');
            $table->json('buttons')->nullable();
            $table->timestamps();
            
            $table->unique(['status', 'language']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whatsapp_confirmation_templates');
    }
}
