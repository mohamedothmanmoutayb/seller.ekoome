<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingPercentagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_percentages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_country')->nullable();
            $table->enum('scenario', ['-', '+', '0']);
            $table->enum('scenario_type', ['upsell', 'callcenter', 'delivered'])->nullable();
            $table->decimal('percentage_upsell')->nullable()->default(0);
            $table->decimal('percentage_callcenter')->nullable()->default(0);
            $table->decimal('percentage_delivred')->nullable()->default(0);
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
        Schema::dropIfExists('setting_percentages');
    }
}
