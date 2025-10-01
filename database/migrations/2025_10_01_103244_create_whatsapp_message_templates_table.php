<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappMessageTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_message_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('business_account_id')->index('whatsapp_message_templates_business_account_id_foreign');
            $table->string('template_id')->nullable();
            $table->string('name');
            $table->string('category');
            $table->string('language', 10);
            $table->text('header')->nullable();
            $table->text('body');
            $table->text('footer')->nullable();
            $table->json('components')->nullable();
            $table->json('meta')->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whatsapp_message_templates');
    }
}
