<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAiAgentKnowledgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ai_agent_knowledges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ai_agent_id')->index('ai_agent_knowledges_ai_agent_id_foreign');
            $table->string('title');
            $table->text('body')->nullable();
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
        Schema::dropIfExists('ai_agent_knowledges');
    }
}
