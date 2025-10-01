<?php

namespace App\Http\Controllers;

use App\Http\Services\TwilioService;
use App\Models\Lead;
use App\Models\User;
use App\Models\WhatsappAnalyticsPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WhatsappAnalyticsController extends Controller
{
    public function index()
    {
        $preferences = WhatsappAnalyticsPreference::where('user_id', Auth::id())->first();
        
        return view('backend.plugins.analitics', [
            'preferences' => $preferences
        ]);
    }

    public function savePreferences(Request $request)
    {
        $validated = $request->validate([
            'daily' => 'nullable|array',
            'weekly' => 'nullable|array',
            'monthly' => 'nullable|array',
        ]);

        $preferences = WhatsappAnalyticsPreference::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'daily' => $validated['daily'] ?? null,
                'weekly' => $validated['weekly'] ?? null,
                'monthly' => $validated['monthly'] ?? null,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Preferences saved successfully!'
        ]);
    }

    public function sendWhatsappAnalytics($period = null)
    {
        $users = User::whereHas('whatsappAnalyticsPreferences', function($query) use ($period) {
            if ($period) {
                $query->whereNotNull($period)
                    ->whereJsonLength($period, '>', 0);
            } else {
                $query->where(function($q) {
                    $q->whereNotNull('daily')->whereJsonLength('daily', '>', 0)
                    ->orWhereNotNull('weekly')->whereJsonLength('weekly', '>', 0)
                    ->orWhereNotNull('monthly')->whereJsonLength('monthly', '>', 0);
                });
            }
        })->get();

        if ($users->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No users with active preferences found '
            ]);
        }

        $results = [];
        foreach ($users as $user) {
            $preferences = $user->whatsappAnalyticsPreferences;
            $message = "Hello {$user->name},\n\nYour requested analytics:\n\n";
            
            if ($period === null || $period === 'daily') {
                if (!empty($preferences->daily)) {
                    $message .= "📊 Daily Analytics:\n";
                    foreach ($preferences->daily as $item) {
                        $data = $this->getAnalyticsData('daily', $item);
                        $message .= "- " . $this->formatAnalyticsItem($item, $data) . "\n";
                    }
                    $message .= "\n";
                }
            }
            
            if ($period === null || $period === 'weekly') {
                if (!empty($preferences->weekly)) {
                    $message .= "📅 Weekly Analytics:\n";
                    foreach ($preferences->weekly as $item) {
                        $data = $this->getAnalyticsData('weekly', $item);
                        $message .= "- " . $this->formatAnalyticsItem($item, $data) . "\n";
                    }
                    $message .= "\n";
                }
            }
            
            if ($period === null || $period === 'monthly') {
                if (!empty($preferences->monthly)) {
                    $message .= "🗓 Monthly Analytics:\n";
                    foreach ($preferences->monthly as $item) {
                        $data = $this->getAnalyticsData('monthly', $item);
                        $message .= "- " . $this->formatAnalyticsItem($item, $data) . "\n";
                    }
                }
            }

            $message .= "\nThank you for using our service!";

            $sendResult = $this->sendWhatsappMessage($user->phone, $message);
            
            $results[] = [
                'user_id' => $user->id,
                'phone' => $user->phone,
                'success' => $sendResult,
                'message' => $sendResult ? 'Sent successfully' : 'Failed to send'
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'WhatsApp analytics sent to users',
            'results' => $results
        ]);
    }

    protected function getAnalyticsData($period, $item)
    {
        $now = now();
        $data = [];
        
        switch ($period) {
            case 'daily':
                $startDate = $now->copy()->startOfDay();
                $endDate = $now->copy()->endOfDay();
                break;
            case 'weekly':
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                break;
            case 'monthly':
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                break;
            default:
                $startDate = $now->copy()->startOfDay();
                $endDate = $now->copy()->endOfDay();
        }

        switch ($item) {
            case 'performance_agent_confirmation':
                $agents = User::whereHas('rol', function($query) {
                    $query->where('name', 'Agent confirmation');
                })->get();

                $agentPerformances = [];
                
                foreach ($agents as $agent) {
                    $confirmed = Lead::where('status_confirmation', 'confirmed')
                        ->where('id_assigned', $agent->id) 
                        ->whereBetween('date_confirmed', [$startDate, $endDate])
                        ->count();
                        
                    $totalAssigned = Lead::where('id_assigned', $agent->id)
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->count();
                        
                    $rate = $totalAssigned > 0 ? round(($confirmed / $totalAssigned) * 100) : 0;
                    
                    $agentPerformances[] = [
                        'agent_id' => $agent->id,
                        'agent_name' => $agent->name,
                        'confirmed' => $confirmed,
                        'total_assigned' => $totalAssigned,
                        'confirmation_rate' => $rate
                    ];
                }
                
                $totalConfirmed = array_sum(array_column($agentPerformances, 'confirmed'));
                $totalAssigned = array_sum(array_column($agentPerformances, 'total_assigned'));
                $overallRate = $totalAssigned > 0 ? round(($totalConfirmed / $totalAssigned) * 100) : 0;
                
                return [
                    'value' => $overallRate,
                    'unit' => '%',
                    'details' => [
                        'total_confirmed' => $totalConfirmed,
                        'total_assigned' => $totalAssigned,
                        'agents' => $agentPerformances
                    ]
                ];

            case 'performance_last_mile':
                $delivered = Lead::where('status_livrison', 'delivered')
                    ->whereBetween('delivered_at', [$startDate, $endDate])
                    ->count();
                    
                $shipped = Lead::where('status_livrison', 'shipped')
                    ->whereBetween('date_shipped', [$startDate, $endDate])
                    ->count();
                    
                $total = $delivered + $shipped;
                $rate = $total > 0 ? round(($delivered / $total) * 100) : 0;
                
                return [
                    'value' => $rate,
                    'unit' => '%',
                    'details' => [
                        'delivered' => $delivered,
                        'shipped' => $shipped
                    ]
                ];

            case 'performance_delivery_man':
                $delivered = Lead::where('status_livrison', 'delivered')
                    ->whereBetween('delivered_at', [$startDate, $endDate])
                    ->count();
                    
                $attempted = Lead::where('status_livrison', '!=', 'unpacked')
                    ->whereBetween('date_shipped', [$startDate, $endDate])
                    ->count();
                    
                $rate = $attempted > 0 ? round(($delivered / $attempted) * 100) : 0;
                
                return [
                    'value' => $rate,
                    'unit' => '%',
                    'details' => [
                        'delivered' => $delivered,
                        'attempted' => $attempted
                    ]
                ];

            case 'total_spend_expenses':
                $shippingFees = Lead::whereBetween('created_at', [$startDate, $endDate])
                    ->sum('shipping_fees');
                    
                $codFees = Lead::whereBetween('created_at', [$startDate, $endDate])
                    ->sum('fees_cod');
                    
                $total = $shippingFees + $codFees;
                
                return [
                    'value' => $total,
                    'unit' => 'USD',
                    'details' => [
                        'shipping_fees' => $shippingFees,
                        'cod_fees' => $codFees
                    ]
                ];

            case 'calculate_roi':
                $totalRevenue = Lead::where('status_payment', 'paid')
                    ->whereBetween('updated_at', [$startDate, $endDate])
                    ->sum('lead_value');
                    
                $totalExpenses = Lead::whereBetween('created_at', [$startDate, $endDate])
                    ->sum(DB::raw('shipping_fees + fees_cod'));
                    
                $profit = $totalRevenue - $totalExpenses;
                $roi = $totalExpenses > 0 ? round(($profit / $totalExpenses) * 100) : 0;
                
                return [
                    'value' => $roi,
                    'unit' => '%',
                    'details' => [
                        'revenue' => $totalRevenue,
                        'expenses' => $totalExpenses,
                        'profit' => $profit
                    ]
                ];

            default:
                return [
                    'value' => 0,
                    'unit' => '',
                    'details' => []
                ];
        }
    }

    protected function formatAnalyticsItem($item, $data)
    {
        if ($item === 'performance_agent_confirmation') {
            $message = "✅ Agent Confirmation Performance\n";
            $message .= "Overall Rate: {$data['value']}%\n";
            $message .= "Total Confirmed: {$data['details']['total_confirmed']}\n";
            $message .= "Total Assigned: {$data['details']['total_assigned']}\n\n";
            
            $message .= "Agent Breakdown:\n";
            foreach ($data['details']['agents'] as $agent) {
                $message .= "👤 {$agent['agent_name']}: {$agent['confirmation_rate']}% ";
                $message .= "({$agent['confirmed']}/{$agent['total_assigned']})\n";
            }
            
            return $message;
        }
        $formats = [
            'performance_last_mile' => [
                'title' => 'Last Mile Delivery Rate',
                'format' => "🚚 {title}: {value}{unit}\nDelivered: {delivered}\nShipped: {shipped}",
                'emoji' => '📦'
            ],
            'performance_delivery_man' => [
                'title' => 'Delivery Man Success Rate',
                'format' => "🏃‍♂️ {title}: {value}{unit}\nDelivered: {delivered}\nAttempted: {attempted}",
                'emoji' => '👨‍💼'
            ],
            'total_spend_expenses' => [
                'title' => 'Total Spend Expenses',
                'format' => "💰 {title}: {value}{unit}\nShipping: {shipping_fees}{unit}\nCOD Fees: {cod_fees}{unit}",
                'emoji' => '💸'
            ],
            'calculate_roi' => [
                'title' => 'Return on Investment',
                'format' => "📈 {title}: {value}{unit}\nRevenue: {revenue}{unit}\nExpenses: {expenses}{unit}\nProfit: {profit}{unit}",
                'emoji' => '🔄'
            ]
        ];

        $format = $formats[$item] ?? [
            'title' => ucwords(str_replace('_', ' ', $item)),
            'format' => "{title}: {value}{unit}",
            'emoji' => '📊'
        ];

        $placeholders = array_merge(
            ['title' => $format['title'], 'value' => $data['value'], 'unit' => $data['unit']],
            $data['details']
        );

        $message = $format['emoji'] . ' ' . $format['title'] . ': ' . $data['value'] . $data['unit'];
        
        if (!empty($data['details'])) {
            $message .= "\n" . implode("\n", array_map(
                fn($k, $v) => ucwords(str_replace('_', ' ', $k)) . ": $v" . (in_array($k, ['revenue', 'expenses', 'profit', 'shipping_fees', 'cod_fees']) ? $data['unit'] : ''),
                array_keys($data['details']),
                array_values($data['details'])
            ));
        }

        return $message;
    }

    protected function sendWhatsappMessage($phone, $message)
    {
        $twilioService = new TwilioService();
        try {
            $response = $twilioService->sendWhatsAppMessage(
                "+212782315209",
                ['body' => $message]
            );
            
            return !isset($response->original['error']);
        } catch (\Exception $e) {
            Log::error("WhatsApp send failed: " . $e->getMessage());
            return false;
        }
    }

}