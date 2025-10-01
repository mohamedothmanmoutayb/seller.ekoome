<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_lead')->nullable();
            $table->string('country_id', 225)->nullable();
            $table->string('id_user')->nullable();
            $table->string('id_delivery')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->string('comment')->nullable();
            $table->string('date')->nullable();
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
        Schema::dropIfExists('history_status');
    }
}
