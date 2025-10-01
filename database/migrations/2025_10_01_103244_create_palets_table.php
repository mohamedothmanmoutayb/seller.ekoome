<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('palets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_row', 250)->nullable();
            $table->string('id_warehouse')->nullable();
            $table->string('name')->nullable();
            $table->text('cod_bar')->nullable();
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
        Schema::dropIfExists('palets');
    }
}
