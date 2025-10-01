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
            $table->integer('id_supplier')->nullable();
            $table->text('ref')->nullable();
            $table->string('id_product')->nullable();
            $table->string('id_country')->Nullable();
            $table->string('quantity_sent')->nullabe();
            $table->string('quantity_received')->nullable();
            $table->string('quantity_real')->nullable();
            $table->string('shipping_country')->nullable();
            $table->string('nbr_packages')->nullabe();
            $table->string('weight')->nullable();
            $table->string('expedition_mode')->nullable();
            $table->string('expidtion_date')->nullable();
            $table->string('name_shipper')->nullable();
            $table->string('phone_shipper')->nullable();
            $table->string('price')->nullable();
            $table->string('status')->default('En attente');
            $table->string('status_payment')->default('not paid');
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
        Schema::dropIfExists('imports');
    }
}
