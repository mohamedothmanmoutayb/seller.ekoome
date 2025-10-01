<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLightfunnelStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lightfunnel_stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('cursor')->nullable();
            $table->string('account_id');
            $table->string('domaine_url');
            $table->longText('access_token');
            $table->string('refresh_token')->nullable();
            $table->string('status')->default('INSTALLED');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lightfunnel_stores');
    }
}
