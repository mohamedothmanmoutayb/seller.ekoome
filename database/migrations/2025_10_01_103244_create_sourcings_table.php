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
            $table->bigIncrements('id');
            $table->string('id_country');
            $table->string('id_user');
            $table->string('ref');
            $table->string('product_name')->nullable();
            $table->text('link')->nullable();
            $table->text('image')->nullable();
            $table->string('quantity')->nullable();
            $table->string('price')->nullable();
            $table->string('unite_price')->nullable();
            $table->string('total')->nullable();
            $table->text('note')->nullable();
            $table->string('method_shipping')->nullable();
            $table->string('status_confirmation')->nullable()->default('pending');
            $table->string('status_livrison')->nullable()->default('pending');
            $table->string('status_payment')->nullable()->default('unpaid');
            $table->string('document')->nullable();
            $table->date('date_arrival')->nullable();
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
