<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappOffersTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_offers_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('language'); 
            $table->text('template');
            $table->timestamps();
            
            $table->unique(['name', 'language']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whatsapp_offers_templates');
    }
}
