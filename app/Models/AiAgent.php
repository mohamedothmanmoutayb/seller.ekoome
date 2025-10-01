<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AiAgentKnowledge;

class AiAgent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sexe',
        'language',
        'product_languages',
        'title',
        'body',
        'actions',
        'custom_prompt',
    ];

    protected $casts = [
        'product_languages' => 'array', 
    ];


    public function knowledgeEntries()
{
    return $this->hasMany(AiAgentKnowledge::class);
}

}
