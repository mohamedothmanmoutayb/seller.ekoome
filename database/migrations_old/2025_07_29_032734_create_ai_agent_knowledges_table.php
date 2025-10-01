<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAiAgentKnowledgesTable extends Migration
{
    public function up(): void
    {
        Schema::create('ai_agent_knowledges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_agent_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('body')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_agent_knowledges');
    }
}
