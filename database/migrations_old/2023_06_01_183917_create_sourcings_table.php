<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourcingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sourcings', function (Blueprint $table) {
            $table->id();
            $table->string('id_country');
            $table->string('id_user');
            $table->string('product_name')->nullable();
            $table->text('link')->nullable();
            $table->string('quantity')->nullable();
            $table->string('price')->nullable();
            $table->text('note')->nullable();
            $table->string('status_confirmation')->nullable();
            $table->string('status_livrison')->nullable();
            $table->string('status_payment')->nullable();
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
        Schema::dropIfExists('sourcings');
    }
}
