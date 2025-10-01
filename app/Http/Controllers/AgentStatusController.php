<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\HistoryStatu;
use Carbon\Carbon;

class AgentStatusController extends Controller
{
    public function getAgents()
    {
        $agents = User::whereHas('rol', function($query) {
            $query->where('name', 'Agent confirmation');
        })
            ->with(['latestHistory' => function($query) {
                $query->latest()->limit(1);
            }])
            ->get()
            ->map(function($agent) {
                return [
                    'id_user' => $agent->id,
                    'name' => $agent->name,
                    'last_activity' => optional($agent->latestHistory)->first()->created_at ?? null
                ];
            });
            
        return response()->json($agents);
    }

    public function getAgentHistory($agentId)
    {
        $today = Carbon::today()->toDateString();

        $history = HistoryStatu::with(['lead:id,n_lead'])->where('id_user', $agentId)
            ->whereDate('created_at', $today)
            ->orderBy('created_at', 'DESC')
            ->get(['id_lead', 'status', 'comment', 'created_at']);
            
        return response()->json($history);
    }
    
}