<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAiAgentKnowledgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ai_agent_knowledges', function (Blueprint $table) {
            $table->foreign(['ai_agent_id'])->references(['id'])->on('ai_agents')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ai_agent_knowledges', function (Blueprint $table) {
            $table->dropForeign('ai_agent_knowledges_ai_agent_id_foreign');
        });
    }
}
