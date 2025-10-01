<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_country')->nullable();
            $table->integer('id_province')->nullable()->index('id_province');
            $table->string('id_city_lastmille', 225)->nullable();
            $table->string('name')->nullable();
            $table->string('last_mille', 225)->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('fees_delivered', 225)->nullable();
            $table->string('fees_returned', 225)->nullable()->default('0');
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
        Schema::dropIfExists('cities');
    }
}
