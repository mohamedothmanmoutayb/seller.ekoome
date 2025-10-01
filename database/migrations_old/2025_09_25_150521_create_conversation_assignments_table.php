<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationAssignmentsTable extends Migration
{
    public function up()
    {
        Schema::create('conversation_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('whats_app_conversations')->onDelete('cascade');
            $table->foreignId('assigned_to')->constrained('users')->onDelete('cascade');
            $table->foreignId('assigned_by')->constrained('users')->onDelete('cascade');
            $table->text('reason')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->boolean('is_manager_assigned')->default(false);
            $table->timestamp('assigned_at');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            
            $table->index(['assigned_to', 'assigned_at']);
            $table->index(['is_manager_assigned', 'assigned_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('conversation_assignments');
    }
}