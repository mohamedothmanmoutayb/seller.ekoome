<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref')->nullable();
            $table->string('reference_fiscale')->nullable();
            $table->string('id_warehouse')->nullable();
            $table->string('id_user')->nullable();
            $table->string('id_agent')->nullable();
            $table->integer('total_entred');
            $table->string('lead_entred')->nullable();
            $table->string('confirmation_fees', 225)->default('0');
            $table->string('shipping_fees', 225)->default('0');
            $table->string('lead_upsell')->nullable();
            $table->string('fullfilment', 225);
            $table->string('lead_delivered')->nullable();
            $table->integer('total_delivered');
            $table->string('order_delivered')->nullable();
            $table->integer('total_return');
            $table->string('order_return')->nullable();
            $table->string('vat', 225)->nullable();
            $table->string('codfess', 225)->nullable();
            $table->string('management_return', 225)->nullable();
            $table->string('amount_order', 225);
            $table->string('amount_last_invoice')->nullable();
            $table->string('amount')->nullable();
            $table->string('storage', 225)->nullable();
            $table->date('date_payment')->nullable();
            $table->text('transaction')->nullable();
            $table->string('island_shipping', 225)->nullable()->default('0');
            $table->string('island_shipping_count', 225)->nullable()->default('0');
            $table->string('island_return', 225)->nullable()->default('0');
            $table->string('island_return_count', 225)->nullable()->default('0');
            $table->string('menor_island')->nullable();
            $table->string('menor_island_count')->nullable();
            $table->string('menor_island_return')->nullable();
            $table->string('menor_island_return_count')->nullable();
            $table->string('status')->nullable();
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('invoices');
    }
}
