<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AIController extends Controller
{
    public function handleQuery(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string'
        ]);

        $phone = $request->input('phone');
        $message = $request->input('message');

        Log::info('AI Request:', [
            'phone' => $phone,
            'message' => $message
        ]);

        try {
            $process = new Process([
                '/usr/bin/python3',
                base_path('storage/app/python/.idea/ai_agent.py'),
                '--phone',
                $phone,
                '--question',
                $message
            ]);
            Log::info('Running AI process:', [
                'command' => $process->getCommandLine()
            ]);
            $process->run();
            
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            
            $output = $process->getOutput();
            
            return response()->json([
                'response' => trim($output)
            ]);
            
        } catch (\Exception $e) {
            Log::error("AI Query Failed: " . $e->getMessage());
            return response()->json([
                'error' => 'AI service unavailable',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}