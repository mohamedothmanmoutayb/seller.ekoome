<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('whatsapp_message_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_account_id')->constrained('whatsapp_business_accounts')->cascadeOnDelete();
            $table->string('template_id')->nullable();
            $table->string('name');
            $table->string('category');
            $table->string('language', 10);
            $table->text('header')->nullable();
            $table->text('body');
            $table->text('footer')->nullable();
            $table->json('components')->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['business_account_id', 'name', 'language']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('whatsapp_message_templates');
    }
};