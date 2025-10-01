<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('description_arabe')->nullable();
            $table->text('description_france')->nullable();
            $table->text('description_anglish')->nullable();
            $table->string('sku')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('weight')->nullable();
            $table->double('price', 8, 2)->nullable();
            $table->string('price2')->nullable();
            $table->string('price3')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->integer('id_country')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('id_category')->nullable();
            $table->integer('id_subcategory')->nullable();
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
        Schema::dropIfExists('offers');
    }
}
