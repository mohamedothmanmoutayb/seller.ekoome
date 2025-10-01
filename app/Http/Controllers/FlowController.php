<?php

namespace App\Http\Controllers;

use App\Models\Flow;
use Illuminate\Http\Request;

class FlowController extends Controller
{
    public function index($businessAccountId)
    {
        $flows = Flow::where('business_account_id', $businessAccountId)->get();
        return view('backend.plugins.whatsapp.chatflow.index', compact('flows', 'businessAccountId'));
    }

    public function create($businessAccount)
    {
        return view('backend.plugins.whatsapp.chatflow.create', compact('businessAccount'));
    }

    public function store(Request $request, $businessAccountId)
    {
        $validated = $request->validate([
            'flow.name' => 'required|string|max:255',
            'flow.nodes' => 'required|array',
            'flow.connections' => 'sometimes|array',
        ]);


        $flowData = [
            'nodes' => $validated['flow']['nodes'],
            'connections' => isset($validated['flow']['connections']) ? $validated['flow']['connections'] : [],
        ];

        if ($request->has('flow.id')) {
            $flow = Flow::findOrFail($request->input('flow.id'));
            
            $flow->update([
                'name' => $validated['flow']['name'],
                'flow_data' => $flowData, 
            ]);
            
            $message = 'Flow updated successfully!';
        } else {
            $flow = Flow::create([
                'business_account_id' => $businessAccountId,
                'name' => $validated['flow']['name'],
                'flow_data' => $flowData, 
            ]);
            
            $message = 'Flow created successfully!';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'flow' => $flow
        ]);
    }


    public function show($businessAccountId, Flow $flow)
    {
        return view('backend.plugins.whatsapp.chatflow.show', compact('flow', 'businessAccountId'));
    }

    public function edit($businessAccountId, Flow $flow)
    {
        $flowData = $flow->flow_data ?? [];

        
        return view('backend.plugins.whatsapp.chatflow.create', [
            'businessAccountId' => $businessAccountId,
            'flow' => $flow,
            'flowData' => $flowData,
            'businessAccount' => $businessAccountId
        ]);
    }

    public function update(Request $request, $businessAccountId, Flow $flow)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'flow_data' => 'required|json'
        ]);

        $flow->update([
            'name' => $validated['name'],
            'flow_data' => json_decode($validated['flow_data'], true)
        ]);

        return redirect()->route('business.flows.show', [
            'businessAccount' => $businessAccountId,
            'flow' => $flow->id
        ])->with('success', 'Flow updated successfully!');
    }

    public function destroy($businessAccountId, Flow $flow)
    {
        $flow->delete();
        return redirect()->route('business.flows.index', $businessAccountId)
            ->with('success', 'Flow deleted successfully!');
    }
}