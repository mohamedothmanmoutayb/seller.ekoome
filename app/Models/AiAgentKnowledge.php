<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AiAgent;

class AiAgentKnowledge extends Model
{
    use HasFactory;

    protected $table = 'ai_agent_knowledges';

    protected $fillable = ['ai_agent_id', 'title', 'body'];

public function agent()
{
    return $this->belongsTo(AiAgent::class, 'ai_agent_id');
}

}
