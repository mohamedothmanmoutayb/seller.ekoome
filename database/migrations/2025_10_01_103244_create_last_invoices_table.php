<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLastInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('last_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_user', 225)->nullable();
            $table->string('id_warehouse', 250)->nullable();
            $table->string('id_invoice')->nullable();
            $table->string('id_invoice_negative')->nullable();
            $table->string('amount')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('last_invoices');
    }
}
