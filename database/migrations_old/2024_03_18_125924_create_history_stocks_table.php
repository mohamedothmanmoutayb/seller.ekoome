<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nulled();
            $table->string('id_product')->nulled();
            $table->string('quantity')->nulled();
            $table->string('note')->nulled();
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
        Schema::dropIfExists('history_stocks');
    }
}
