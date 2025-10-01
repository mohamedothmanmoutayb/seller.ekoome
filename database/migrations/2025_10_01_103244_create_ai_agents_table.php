<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAiAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ai_agents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->enum('sexe', ['male', 'female']);
            $table->string('language');
            $table->json('product_languages');
            $table->json('actions')->nullable();
            $table->text('custom_prompt')->nullable();
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
        Schema::dropIfExists('ai_agents');
    }
}
