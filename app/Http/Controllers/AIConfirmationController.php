<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Models\AiAgent;

class AIConfirmationController extends Controller
{
    public function handleQuery(Request $request)
    {
        $question = $request->input('question');
        $phone = $request->input('phone');
        $agentId = $request->input('ai_agent_id'); 

        Log::info('AI Request:', compact('question', 'phone', 'agentId'));

        $agent = AiAgent::with('knowledgeEntries')->find($agentId);

        if (!$agent) {
            return response()->json(['error' => 'AI agent not found'], 404);
        }

        $allowedActions = json_decode($agent->actions, true);
        $customPrompt = $agent->custom_prompt ?? '';
        $language = $agent->language;

        $knowledge = $agent->knowledgeEntries->map(function ($entry) {
            return [
                'title' => $entry->title,
                'body' => $entry->body
            ];
        });

        $agentData = [
            'name' => $agent->name,
            'actions' => $allowedActions,
            'custom_prompt' => $customPrompt,
            'knowledge' => $knowledge,
            'language' => $language,
        ];
        
        $systemPrompt = $this->buildSystemPrompt($agentData);

        Log::info('AI Request:', [
            'question' => $question,
            'phone' => $phone 
        ]);

        try {
           $process = new Process([
                '/usr/bin/python3',
                base_path('storage/app/python/.idea/ai_agent.py'),
                '--phone',
                $phone,
                '--question',
                $question,
                 '--system_prompt',
                $systemPrompt,
                '--actions', 
                json_encode($allowedActions),
                '--agent_name',
                 $agent->name
            ]);

            $process->run();
            
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            
            return response()->json([
                'response' => $process->getOutput()
            ]);
            
        } catch (\Exception $e) {
            Log::error("AI Query Failed: " . $e->getMessage());
            return response()->json([
                'error' => 'AI service unavailable'
            ], 500);
        }
    }

   public function buildSystemPrompt(array $agentData): string
{
    $prompt = "You are an AI assistant named {$agentData['name']}.\n\n";

    if (!empty($agentData['knowledge'])) {
        $prompt .= "Here is some background information you must rely on when answering questions:\n";
        foreach ($agentData['knowledge'] as $info) {
            $prompt .= "- {$info['title']}: {$info['body']}\n";
        }
        $prompt .= "\n";
    }

    if (!empty($agentData['language'])) {
        $prompt .= "Always respond in {$agentData['language']}.\n\n";
    }

    if (!empty($agentData['custom_prompt'])) {
        $prompt .= "Additional instructions: {$agentData['custom_prompt']}\n";
    }

     $prompt .= <<<EOT
        You are a helpful customer service assistant. 
         - Always start your very first message with an introduction in {$agentData['language']}, like: 
          "👋 Hello, I am {$agentData['name']}. How can I help you today?" 
          (translated fully to {$agentData['language']}).
        - If the user only greets you (hi, hello, salam, bonjour, etc.), reply with that introduction again in {$agentData['language']} and offer help.
        - If the user greets you and also asks a question, greet first in {$agentData['language']}, then continue to answer.

        Guidelines:
       
        - Be concise but informative
        - Use emojis where appropriate
        - Format lists clearly
        - Highlight important info
        - Maintain a professional, friendly tone
        - Avoid technical jargon
        - If the question is in Moroccan Darija, answer with it and be like a brother to them to feel you
        - If the SQL query is about the product details, retrieve the information from the link attribute and don't send the link, just a simple description
        - Do not include SQL or database details
        - Do not include sensitive information like passwords or credit card numbers
        - Please, if the link provided is in the column link attribute, search in the link and retrieve the information and don't send the link, just a simple description
        - Never reveal sensitive or technical details
        EOT;

    return trim($prompt);
}

 // - Use {'Arabic' if lang == 'ar' else 'French' if lang == 'fr' else 'English'}
}