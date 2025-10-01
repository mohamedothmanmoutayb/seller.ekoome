<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppBusinessAccount;
use App\Models\WhatsAppConversation;
use App\Models\WhatsappMessage;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class WhatsAppDashboardController extends Controller
{
    public function index()
    {
        $accounts = WhatsAppBusinessAccount::with(['templates', 'flows', 'conversations', 'assignedUsers'])
            ->where('user_id', auth()->id())
            ->get();
        
        $metrics = [
            'total_conversations' => 0,
            'total_clients' => 0,
            'active_conversations' => 0,
            'messages_today' => 0,
            'response_rate' => 0,
            'avg_response_time' => 0,
        ];

        $agents = User::where(function($query) {
                $query->where('id_role', 3)
                    ->where('is_active', true);
            })
            ->orWhere('id_role', 4)
            ->orWhere('id', auth()->id())
            ->get(['id', 'name', 'email', 'id_role']);

        return view('backend.plugins.whatsapp.index', compact(
            'metrics',
            'accounts',
            'agents'
        ));
    }

    /**
     * Get current chatbot status
     */
    public function getChatbotStatus($accountId)
    {
        try {
            $account = WhatsAppBusinessAccount::where('id', $accountId)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            return response()->json([
                'status' => $account->chatbot_status ?? 'inactive',
                'account_id' => $account->id
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'inactive',
                'error' => 'Failed to fetch chatbot status'
            ], 500);
        }
    }

    /**
     * Update chatbot status
     */
    public function updateChatbotStatus(Request $request, $accountId)
    {
        try {
            $account = WhatsAppBusinessAccount::where('id', $accountId)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            $status = $request->input('status', 'inactive');
            
            // $account->update(['chatbot_status' => $status]);
            
            return response()->json([
                'success' => true,
                'message' => 'Chatbot status updated successfully',
                'status' => $status
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update chatbot status'
            ], 500);
        }
    }

    /**
     * Get account metrics and statistics
     */
    public function getAccountMetrics($accountId)
    {
        try {
            $account = WhatsAppBusinessAccount::where('id', $accountId)
                ->firstOrFail();

            $metrics = $this->calculateAccountMetrics($account);
            
            return response()->json([
                'success' => true,
                'metrics' => $metrics
            ]);
            
        } catch (\Exception $e) {
            \Log::error('WhatsApp Metrics Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch metrics',
                'metrics' => $this->getDefaultMetrics()
            ], 500);
        }
    }

    /**
     * Calculate meaningful metrics for the account
     */
    private function calculateAccountMetrics($account)
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        
        // Total conversations
        $totalConversations = $account->conversations()->count();
        
        // Total unique clients/contacts
        $totalClients = $account->conversations()
            ->distinct('contact_number')
            ->count();
        
        // Active conversations (last 24 hours)
        $activeConversations = $account->conversations()
            ->where('last_message_at', '>=', $today->subDay())
            ->count();
        
        // Messages today - through conversations relationship
        $messagesToday = WhatsappMessage::whereHas('conversation', function($query) use ($account, $today) {
                $query->where('whatsapp_business_account_id', $account->id);
            })
            ->whereDate('created_at', $today)
            ->count();
        
        // Sent messages today
        $sentMessagesToday = WhatsappMessage::whereHas('conversation', function($query) use ($account, $today) {
                $query->where('whatsapp_business_account_id', $account->id);
            })
            ->whereDate('created_at', $today)
            ->where('direction', 'out')
            ->count();
        
        // Received messages today
        $receivedMessagesToday = WhatsappMessage::whereHas('conversation', function($query) use ($account, $today) {
                $query->where('whatsapp_business_account_id', $account->id);
            })
            ->whereDate('created_at', $today)
            ->where('direction', 'in')
            ->count();
        
        // Conversations with replies
        $conversationsWithReplies = $account->conversations()
            ->whereHas('messages', function($query) {
                $query->where('direction', 'out');
            })
            ->count();
        
        $responseRate = $totalConversations > 0 
            ? round(($conversationsWithReplies / $totalConversations) * 100, 1)
            : 0;
        
        // Average response time
        $avgResponseTime = $this->calculateAverageResponseTime($account);
        
        // Template usage
        $templatesUsed = $account->templates()->count();
        
        // Flows usage
        $flowsUsed = $account->flows()->count();
        
        // Assigned agents
        $assignedAgentsCount = $account->assignedUsers()->count();
        
        // Message types breakdown
        $messageTypes = $this->getMessageTypesBreakdown($account);
        
        return [
            'total_conversations' => $totalConversations,
            'total_clients' => $totalClients,
            'active_conversations' => $activeConversations,
            'messages_today' => $messagesToday,
            'sent_today' => $sentMessagesToday,
            'received_today' => $receivedMessagesToday,
            'response_rate' => $responseRate,
            'avg_response_time' => $avgResponseTime,
            'templates_used' => $templatesUsed,
            'flows_used' => $flowsUsed,
            'assigned_agents' => $assignedAgentsCount,
            'account_status' => $account->status,
            'phone_number' => $account->phone_number,
            'connected_since' => $account->created_at->format('M d, Y'),
            'message_types' => $messageTypes,
            'last_sync' => $account->last_synced_at ? $account->last_synced_at->diffForHumans() : 'Never',
        ];
    }

    /**
     * Calculate average response time (simplified version)
     */
    private function calculateAverageResponseTime($account)
    {
        // Get conversations that have both incoming and outgoing messages
        $repliedConversations = $account->conversations()
            ->whereHas('messages', function($query) {
                $query->where('direction', 'in');
            })
            ->whereHas('messages', function($query) {
                $query->where('direction', 'out');
            })
            ->with(['messages' => function($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->get();

        $totalResponseTime = 0;
        $count = 0;

        foreach ($repliedConversations as $conversation) {
            $firstIncoming = $conversation->messages->where('direction', 'in')->first();
            $firstOutgoingAfterIncoming = $conversation->messages
                ->where('direction', 'out')
                ->where('created_at', '>', $firstIncoming->created_at)
                ->first();
            
            if ($firstIncoming && $firstOutgoingAfterIncoming) {
                $responseTime = $firstOutgoingAfterIncoming->created_at->diffInMinutes($firstIncoming->created_at);
                $totalResponseTime += $responseTime;
                $count++;
            }
        }

        return $count > 0 ? round($totalResponseTime / $count, 1) : 0;
    }

    /**
     * Get message types breakdown
     */
    private function getMessageTypesBreakdown($account)
    {
        $messageTypes = WhatsappMessage::whereHas('conversation', function($query) use ($account) {
                $query->where('whatsapp_business_account_id', $account->id);
            })
            ->selectRaw('type, count(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        return $messageTypes;
    }

    /**
     * Get message analytics for charts
     */
    public function getMessageAnalytics($accountId)
    {
        try {
            $account = WhatsAppBusinessAccount::where('id', $accountId)
                ->firstOrFail();

            $messageStats = $this->getMessageStatistics($account);
            
            return response()->json([
                'success' => true,
                'analytics' => $messageStats
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Message Analytics Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch message analytics'
            ], 500);
        }
    }

    /**
     * Get message statistics for the last 7 days
     */
    private function getMessageStatistics($account)
    {
        $messageStats = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateString = $date->format('Y-m-d');
            
            // Total messages for this date
            $totalMessages = WhatsappMessage::whereHas('conversation', function($query) use ($account) {
                    $query->where('whatsapp_business_account_id', $account->id);
                })
                ->whereDate('created_at', $dateString)
                ->count();
                
            // Sent messages for this date
            $sentMessages = WhatsappMessage::whereHas('conversation', function($query) use ($account) {
                    $query->where('whatsapp_business_account_id', $account->id);
                })
                ->whereDate('created_at', $dateString)
                ->where('direction', 'out')
                ->count();
                
            // Received messages for this date
            $receivedMessages = WhatsappMessage::whereHas('conversation', function($query) use ($account) {
                    $query->where('whatsapp_business_account_id', $account->id);
                })
                ->whereDate('created_at', $dateString)
                ->where('direction', 'in')
                ->count();
            
            // Conversations for this date
            $conversationsCount = $account->conversations()
                ->whereDate('last_message_at', $dateString)
                ->count();
            
            $messageStats[] = [
                'date' => $date->format('M d'),
                'total' => $totalMessages,
                'sent' => $sentMessages,
                'received' => $receivedMessages,
                'conversations' => $conversationsCount
            ];
        }
        
        return $messageStats;
    }

    /**
     * Get conversation analytics
     */
    public function getConversationAnalytics($accountId)
    {
        try {
            $account = WhatsAppBusinessAccount::where('id', $accountId)
                ->firstOrFail();

            $conversationStats = $this->getConversationStatistics($account);
            
            return response()->json([
                'success' => true,
                'analytics' => $conversationStats
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Conversation Analytics Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch conversation analytics'
            ], 500);
        }
    }

    /**
     * Get conversation statistics
     */
    private function getConversationStatistics($account)
    {
        $recentConversations = $account->conversations()
            ->with(['latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($conversation) {
                return [
                    'contact_number' => $conversation->contact_number,
                    'contact_name' => $conversation->contact_name,
                    'last_message' => $conversation->latestMessage->body ?? 'No messages',
                    'last_message_at' => $conversation->last_message_at ? $conversation->last_message_at->diffForHumans() : 'Never',
                    'message_count' => $conversation->messages()->count(),
                ];
            });

        return [
            'recent_conversations' => $recentConversations,
            'top_contacts' => $this->getTopContacts($account),
        ];
    }

    /**
     * Get top contacts by message count
     */
    private function getTopContacts($account)
    {
        return $account->conversations()
            ->withCount('messages')
            ->orderBy('messages_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function($conversation) {
                return [
                    'contact_number' => $conversation->contact_number,
                    'contact_name' => $conversation->contact_name,
                    'message_count' => $conversation->messages_count,
                    'last_contact' => $conversation->last_message_at ? $conversation->last_message_at->diffForHumans() : 'Never',
                ];
            });
    }

    /**
     * Default metrics when data is not available
     */
    private function getDefaultMetrics()
    {
        return [
            'total_conversations' => 0,
            'total_clients' => 0,
            'active_conversations' => 0,
            'messages_today' => 0,
            'sent_today' => 0,
            'received_today' => 0,
            'response_rate' => 0,
            'avg_response_time' => 0,
            'templates_used' => 0,
            'flows_used' => 0,
            'assigned_agents' => 0,
            'account_status' => 'active',
            'phone_number' => 'N/A',
            'connected_since' => 'N/A',
            'last_sync' => 'Never',
            'message_types' => [],
        ];
    }
}