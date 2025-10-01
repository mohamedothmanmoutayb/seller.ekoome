<?php

namespace App\Http\Controllers;

use App\Events\ConversationAssigned;
use App\Models\Client;
use App\Models\Communication;
use Illuminate\Http\Request;
use App\Models\ConversationAssignment;
use App\Models\User;
use App\Models\Lead;
use App\Models\WhatsAppConversation;

class AgentWhatsappController extends Controller
{

    public function getAssignedAgent($clientId)
    {
        try {
            $client = Client::findOrFail($clientId);
            $conversation = WhatsAppConversation::where('contact_number', $client->phone1)->first();
            
            if (!$conversation) {
                return response()->json([
                    'success' => true,
                    'agent' => null,
                    'message' => 'No conversation found for this client'
                ]);
            }

            $assignment = ConversationAssignment::with('assignedTo')
                ->where('conversation_id', $conversation->id)
                ->whereNull('resolved_at')
                ->first();

            if ($assignment && $assignment->assignedTo) {
                return response()->json([
                    'success' => true,
                    'agent' => [
                        'id' => $assignment->assignedTo->id,
                        'name' => $assignment->assignedTo->name,
                        'email' => $assignment->assignedTo->email,
                        'role' => $assignment->assignedTo->id_role,
                        'avatar' => $assignment->assignedTo->avatar ? 
                                asset('storage/' . $assignment->assignedTo->avatar) : 
                                '/public/assets/images/default-avatar.png'
                    ]
                ]);
            }

            return response()->json([
                'success' => true,
                'agent' => null,
                'message' => 'No agent assigned'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error getting assigned agent: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load assigned agent'
            ], 500);
        }
    }
      public function getAgentsWithWorkload()
    {
        try {
            $agents = User::whereIn('id_role', [3, 4])
                ->where('is_active', true)
                ->withCount(['conversationAssignments as active_assignments' => function($query) {
                    $query->whereNull('resolved_at');
                }])
                ->withCount(['conversationAssignments as unread_conversations' => function($query) {
                    $query->whereHas('conversation.messages', function($q) {
                        $q->where('direction', 'in')
                        ->where('read', 0);
                    });
                }])

                ->orderBy('unread_conversations', 'asc')
                ->orderBy('active_assignments', 'asc')
                ->get()
                ->map(function($agent) {
                    return [
                        'id' => $agent->id,
                        'name' => $agent->name,
                        'email' => $agent->email,
                        'role' => $agent->id_role,
                        'role_name' => $agent->id_role == 3 ? 'Agent' : 'Manager',
                        'avatar' => $agent->avatar ? asset('storage/' . $agent->avatar) : '/public/assets/images/default-avatar.png',
                        'unread_count' => $agent->unread_conversations,
                        'active_assignments' => $agent->active_assignments,
                        'workload_score' => $agent->unread_conversations + $agent->active_assignments
                    ];
                });

            return response()->json([
                'success' => true,
                'agents' => $agents
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load agents' . $e->getMessage()
            ], 500);
        }
    }

    public function assignConversation(Request $request)
    {
        try {
            $request->validate([
                'conversation_id' => 'required|exists:whatsapp_conversations,id',
                'assigned_to' => 'required|exists:users,id',
                'reason' => 'nullable|string|max:500',
                'priority' => 'nullable|in:low,medium,high,urgent'
            ]);

            $conversation = WhatsAppConversation::findOrFail($request->conversation_id);
            $client = Client::where("phone1", "=", $conversation->contact_number)
                            ->orWhere("phone2", "=", $conversation->contact_number)
                            ->first();
            $assignTo = User::findOrFail($request->assigned_to);
            
            if (!in_array($assignTo->id_role, [3, 4])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Can only assign to agents or managers'
                ], 400);
            }

            $assignment = ConversationAssignment::updateOrCreate(
                [
                    'conversation_id' => $request->conversation_id,
                    'resolved_at' => null
                ],
                [
                    'assigned_to' => $request->assigned_to,
                    'assigned_by' => auth()->id(),
                    'reason' => $request->reason,
                    'priority' => $request->priority ?? 'medium',
                    'is_manager_assigned' => $assignTo->id_role == 4,
                    'assigned_at' => now()
                ]
            );

            Communication::create([
                'client_id' => $client->id,
                'type' => 'assignment',
                'subject' => 'Conversation Assigned',
                'message' => "Conversation assigned to {$assignTo->name} ({$assignment->priority} priority)" . 
                           ($request->reason ? ". Reason: {$request->reason}" : ""),
                'user_id' => auth()->id()
            ]);

            broadcast(new ConversationAssigned($assignment));
            //boradcat the notification and create it here 


            return response()->json([
                'success' => true,
                'message' => 'Conversation assigned successfully',
                'assignment' => $assignment->load('assignedTo', 'assignedBy')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to assign conversation: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAssignmentHistory($conversationId)
    {
        try {
            $assignments = ConversationAssignment::with(['assignedTo', 'assignedBy'])
                ->where('conversation_id', $conversationId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'assignments' => $assignments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load assignment history'
            ], 500);
        }
    }

    public function getClientOrderHistory($clientId)
    {
        try {
            $orders = Lead::with(['products', 'historystatu', 'deliveryattempts'])
                ->where('client_id', $clientId)
                ->orderBy('created_at', 'DESC')
                ->limit(3)
                ->get()
                ->map(function($lead) {
                    return [
                        'id' => $lead->id,
                        'order_number' => $lead->n_lead,
                        'date' => $lead->created_at->format('M d, Y'),
                        'status' => $lead->status_livrison,
                        'amount' => $lead->lead_value,
                        'products' => $lead->products->pluck('name')->implode(', '),
                        'product_count' => $lead->products->count(),
                        'edit_url' => route('leads.edit', $lead->id)
                    ];
                });

            return response()->json([
                'success' => true,
                'orders' => $orders
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load order history'
            ], 500);
        }
    }


    public function getCurrentAssignment($conversationId)
    {
        try {
            $assignment = ConversationAssignment::with(['assignedTo', 'assignedBy'])
                ->where('conversation_id', $conversationId)
                ->whereNull('resolved_at')
                ->first();

            return response()->json([
                'success' => true,
                'assignment' => $assignment
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load assignment'
            ], 500);
        }
    }
}
