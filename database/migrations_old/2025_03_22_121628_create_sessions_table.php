<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id(); 
            $table->string('phone')->unique(); 
            $table->unsignedBigInteger('seller_id')->nullable(); 
            $table->string('state')->default('initial'); 
            $table->json('context')->nullable(); 
            $table->string('language', 10)->default('en');
            $table->timestamps(); 

            $table->index('phone');
            $table->index('seller_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
