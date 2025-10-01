<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActionsAndCustomPromptToAiAgentsTable extends Migration
{
    public function up()
    {
        Schema::table('ai_agents', function (Blueprint $table) {
            $table->json('actions')->nullable()->after('product_languages');
            $table->text('custom_prompt')->nullable()->after('actions');
        });
    }

    public function down()
    {
        Schema::table('ai_agents', function (Blueprint $table) {
            $table->dropColumn(['actions', 'custom_prompt']);
        });
    }
}
