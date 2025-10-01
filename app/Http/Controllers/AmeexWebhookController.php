<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AmeexWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Ameex Webhook:', $request->all());
        
        $status = $request->input('STATUS_NAME');
        $orderRef = $request->input('CODE');
        
        $lead = Lead::where('tracking', $orderRef)->first();
    
        if (!$lead) {
            return response()->json(['message' => 'Lead not found'], 404);
        }
    
        $statusMappings = [
            'Livré' => 'Delivered',
            'Mise en distribution' => 'In transit',
            'En cours d\'expédition' => 'In transit',
            'Nouveau Colis' => 'Packed',
            'Ramassé' => 'Shipped',
            'Reçu' => 'Shipped',
            'Relancer' => 'Incident',
            'Relancer vers un nouveau client' => 'Incident',
            'Relancer (Suivé)' => 'Incident',
            'Renvoyez vers nouvelle ville' => 'Incident',
            'Retourné' => 'Returned',
            'Expédié' => 'Incident',
            'Attente De Ramassage' => 'Packed',
            'Colis non expédiés' => 'Incident'
        ];
    
        if ($status == "En cours") {
            $status_suivi = $request->input('STATUS_S_NAME');
            $lead->status_livraison = $status;
            $lead->status_suivi = $status_suivi;
        } else {
            // $lead->status_livraison = $status;
            if (array_key_exists($status, $statusMappings)) {
                $lead->status_livraison = $statusMappings[$status];
            }
        }
        
        $lead->save();
        
        return response()->json(['message' => 'Webhook received'], 200);
    }
}
