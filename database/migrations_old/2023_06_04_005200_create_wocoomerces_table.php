<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWocoomercesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wocoomerces', function (Blueprint $table) {
            $table->id();
            $table->string('index')->default('0');
            $table->string('id_user');
            $table->string('id_country');
            $table->string('domain');
            $table->string('consumer_key');
            $table->string('consumer_secret');
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
        Schema::dropIfExists('wocoomerces');
    }
}
