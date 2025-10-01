<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSheetAffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sheet_affiliates', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('id_product');
            $table->string('id_user');
            $table->string('id_warehouse');
            $table->string('sheetid');
            $table->string('sheetname');
            $table->tinyInteger('status')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('sheet_affiliates');
    }
}
