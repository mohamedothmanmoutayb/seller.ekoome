<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AiAgent;
use Illuminate\Support\Facades\Log;
use App\Models\AiAgentKnowledge;

class AiAgentController extends Controller
{

public function index()
{
    $agents = AiAgent::all();
    return view('backend.AiAgent.aiagentapp', compact('agents'));

}

public function show(Request $request, $id)
{
    $agent = AIAgent::with('knowledgeEntries')->find($id);
    $agent->actions = json_decode($agent->actions, true) ?? [];
    if($request->ajax()) {
        return response()->json($agent);
    }
    return view('backend.AiAgent.show', compact('agent'));
}



public function edit($id)
{
    $agent = AiAgent::findOrFail($id);
    return response()->json($agent);
}


public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'sexe' => 'required|in:male,female',
        'language' => 'required|string|max:255',
        'product_languages' => 'required|string', 
    ]);


    Log::info('Creating AI Agent with data: ', $validated);

     AiAgent::create($validated);

    Log::info('AI Agent created successfully: ');

    return response()->json(['message' => 'AI Agent created successfully.']);
}


public function update(Request $request, $id)
{

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'sexe' => 'required|in:male,female',
        'language' => 'nullable|string|max:255',
        'product_languages' => 'nullable|string|max:255',
        'custom_prompt' => 'nullable|string|max:5000', 
    ]);


    $agent = AiAgent::findOrFail($id);
    $agent->update($validated);

    Log::info('AI Agent updated successfully: ', ['id' => $id, 'data' => $validated]);
    return redirect()->route('aiagents.index')->with('success', 'Agent updated successfully!');
}



public function destroy($id)
{
    $agent = AiAgent::findOrFail($id);
    $agent->delete();

    return redirect()->route('aiagents.index')->with('success', 'Agent deleted successfully!');
}

public function list()
{
    $agents = AiAgent::select('id', 'name', 'language', 'sexe', 'custom_prompt')->get();
    return response()->json($agents);
}

public function addKnowledge(Request $request)
{
    $request->validate([
        'agent_id' => 'required|exists:ai_agents,id',
        'title' => 'required|string|max:255',
        'body' => 'nullable|string',
    ]);

    $knowledge = new AiAgentKnowledge();
    $knowledge->ai_agent_id = $request->agent_id;
    $knowledge->title = $request->title;
    $knowledge->body = $request->body;
    $knowledge->save();

    return response()->json([
        'success' => true,
        'message' => 'Knowledge entry added successfully',
        'data' => $knowledge,
    ]);
}


public function getKnowledgeEntry($id)
{
    $entry = AiAgentKnowledge::findOrFail($id);
    return response()->json($entry);
}

public function updateKnowledgeEntry(Request $request, $id)
{
    $entry = AiAgentKnowledge::findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|string',
    ]);

    $entry->title = $request->title;
    $entry->body = $request->body;
    $entry->save();

    return response()->json(['success' => true]);
}

public function destroyentries($id)
{
    $knowledge = AIAgentKnowledge::findOrFail($id);
    $knowledge->delete();

    return response()->json(['success' => true, 'message' => 'Knowledge entry deleted successfully']);
}




public function saveEnabledActions(Request $request, $agentId)
{
    $request->validate([
        'action' => 'required|string',
        'enabled' => 'required|boolean',
    ]);

    $agent = AiAgent::findOrFail($agentId);

    $actions = json_decode($agent->actions ?? '[]', true);
    if (!is_array($actions)) {
        $actions = [];
    }

    $action = $request->input('action');
    $enabled = $request->input('enabled');

    if ($enabled) {
        if (!in_array($action, $actions)) {
            $actions[] = $action;
        }
    } else {
        $actions = array_filter($actions, fn($a) => $a !== $action);
        $actions = array_values($actions);
    }

    $agent->actions = json_encode($actions);
    $agent->save();

    return response()->json([
        'success' => true,
        'actions' => $actions,
    ]);
}


}
