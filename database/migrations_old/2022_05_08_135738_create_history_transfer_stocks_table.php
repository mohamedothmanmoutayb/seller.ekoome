<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryTransferStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_transfer_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('last_warehouse')->nullable();
            $table->string('new_warehouse')->nullable();
            $table->string('id_user')->nullable();
            $table->string('id_stock')->nullable();
            $table->string('last_tagier')->nullable();
            $table->string('new_tagier')->nullable();
            $table->string('quantity')->nullable();
            $table->string('reson')->nullable();
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
        Schema::dropIfExists('history_transfer_stocks');
    }
}
