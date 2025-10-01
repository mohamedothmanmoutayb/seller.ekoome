<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappBusinessAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_business_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_id')->index('account_index');
            $table->unsignedBigInteger('user_id')->index('whatsapp_business_accounts_user_id_foreign');
            $table->string('phone_number')->unique();
            $table->string('phone_number_id')->nullable();
            $table->string('business_id')->nullable();
            $table->longText('access_token')->nullable();
            $table->string('name')->nullable();
            $table->string('currency')->nullable();
            $table->string('timezone')->nullable();
            $table->string('message_template_limit')->nullable();
            $table->string('webhook_verify_token')->nullable();
            $table->dateTime('last_synced_at')->nullable();
            $table->json('meta_data')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('whatsapp_business_accounts');
    }
}
