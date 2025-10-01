<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imports', function (Blueprint $table) {
            $table->increments('id');
            $table->text('ref')->nullable();
            $table->string('type')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->string('id_import')->nullable();
            $table->text('tracking')->nullable();
            $table->string('id_product')->nullable();
            $table->string('id_country')->nullable();
            $table->string('warehouse_id', 225)->nullable();
            $table->string('quantity_sent')->nullable();
            $table->string('quantity_received')->nullable();
            $table->string('quantity_real')->nullable();
            $table->string('shipping_country')->nullable();
            $table->string('nbr_packages')->nullable();
            $table->string('weight')->nullable();
            $table->string('expedition_mode')->nullable();
            $table->string('expidtion_date')->nullable();
            $table->string('name_shipper')->nullable();
            $table->string('phone_shipper')->nullable();
            $table->string('price', 250)->nullable();
            $table->string('status')->default('pending');
            $table->string('status_payment', 250)->nullable()->default('not paid');
            $table->date('date_arrival')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imports');
    }
}
