<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClosingDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closing_days', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_warehouse')->nullable();
            $table->string('id_delivery_payment')->nullable();
            $table->text('ref')->nullable();
            $table->string('total')->nullable();
            $table->string('cash')->nullable();
            $table->string('epayment')->nullable();
            $table->string('epaymentref')->nullable();
            $table->string('preapaid')->nullable();
            $table->string('prepaidref')->nullable();
            $table->string('defferent')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->nullable()->default('pending');
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
        Schema::dropIfExists('closing_days');
    }
}
