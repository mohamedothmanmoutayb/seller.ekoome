<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMappingStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mapping_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_stock');
            $table->string('id_tagier')->nullable();
            $table->string('quantity_map', 250)->nullable();
            $table->string('quantity')->nullable();
            $table->boolean('isactive')->default(true);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mapping_stocks');
    }
}
