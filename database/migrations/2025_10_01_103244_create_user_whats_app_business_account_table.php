<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWhatsAppBusinessAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_whats_app_business_account', function (Blueprint $table) {
            $table->unsignedBigInteger('whats_app_business_account_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->primary(
                ['whats_app_business_account_id', 'user_id'],
                'uwaba_uid_primary' 
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_whats_app_business_account');
    }
}
