<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYoucanStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('youcan_stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained('youcan_accounts')->onDelete('cascade');
            $table->string('store_id'); 
            $table->string('slug');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_email_verified')->default(false);
            $table->string('access_token')->nullable();
            $table->index('store_id');
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
        Schema::dropIfExists('youcan_stores');
    }
}
