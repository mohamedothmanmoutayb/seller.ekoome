<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_import', 250)->nullable();
            $table->string('id_product')->nullable();
            $table->string('id_warehouse')->nullable();
            $table->string('quantity_accept', 225)->nullable();
            $table->string('qunatity')->nullable();
            $table->text('bar_cod')->nullable();
            $table->text('note')->nullable();
            $table->boolean('isactive')->default(true);
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
        Schema::dropIfExists('stocks');
    }
}
