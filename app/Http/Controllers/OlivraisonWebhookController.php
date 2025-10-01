<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Stock;
use App\Models\LeadProduct;
use App\Models\MappingStock;
use App\Models\HistoryStatu;
use App\Models\LastmilleIntegration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Auth;

class OlivraisonWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Olivraison Webhook:', $request->all());
        
        $status = json_decode($request->getContent(), true);
        if(!empty($status['payload']['status'])){
            $check = $status['payload']['status'];
            if($check == "DELIVERED"){
                $lead = Lead::where('tracking',$status['payload']['order_id'])->first();
                if($lead){
                    $lastmille = LastmilleIntegration::where('id_user',$lead->id_user)->where('id_country', $lead->id_country)->first();
                    $feesdelivered = $lastmille->fees_delivered;
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'delivered' , 'fees_livrison' => $feesdelivered]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['status'] = "delivered";
                    $data['comment'] = "delivered";
                    HistoryStatu::insert($data);
                }
            }elseif($check == "PICKUP"){
                $lead = Lead::where('tracking',$status['payload']['order_id'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'shipped']);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['status'] = "shipped";
                    $data['comment'] = "shipped";
                    HistoryStatu::insert($data);
                }
            }elseif($check == "RETURNED"){
                $lead = Lead::where('tracking',$status['payload']['order_id'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'returned']);
                    $leadproducts = LeadProduct::where('id_lead',$lead->id)->get();
                    foreach($leadproducts as $v_product){
                        $stock = Stock::where('id_product',$v_product->id_product)->first();
                        Stock::where('id_product',$v_product->id_product)->update(['qunatity'=> $stock->quantity + $v_product->quantity , 'isactive'=> 1]);
                        $sumM = MappingStock::where('id_stock',$stock->id)->sum('quantity');
                        MappingStock::where('id_stock',$stock->id)->update(['quantity' => $sumM + $v_product->quantity ]);
                    }
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['status'] = "returned";
                    $data['comment'] = "returned";
                    HistoryStatu::insert($data);
                }
            }elseif($check == "TRANSIT"){
                $lead = Lead::where('tracking',$status['payload']['order_id'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'in transit']);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['status'] = "in transit";
                    $data['comment'] = "in transit";
                    HistoryStatu::insert($data);
                }
            }elseif($check == "PICKEDUP" || $check == "INHOUSE"){
                $lead = Lead::where('tracking',$status['payload']['order_id'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'in delivery']);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['status'] = "in delivery";
                    $data['comment'] = "in delivery";
                    HistoryStatu::insert($data);
                }
            }elseif($check == "ENROUTE"){
                $lead = Lead::where('tracking',$status['payload']['order_id'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'in delivery']);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['status'] = "in delivery";
                    $data['comment'] = "in delivery";
                    HistoryStatu::insert($data);
                }
            }elseif($check == "INTERESTED"){
                $lead = Lead::where('tracking',$status['payload']['order_id'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'proseccing' , 'status_suivi' => $check]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['status'] = $check;
                    $data['comment'] = $check;
                    HistoryStatu::insert($data);
                }
            }elseif($check == "SCHEDULED"){
                $lead = Lead::where('tracking',$status['payload']['order_id'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'proseccing' , 'status_suivi' => $check]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['status'] = $check;
                    $data['comment'] = $check;
                    HistoryStatu::insert($data);
                }
            }elseif($check == "REPORTED"){
                $lead = Lead::where('tracking',$status['payload']['order_id'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'proseccing' , 'status_suivi' => $check]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['status'] = $check;
                    $data['comment'] = $check;
                    HistoryStatu::insert($data);
                }
            }elseif($check == "PROGRAMMÉ"){
                $lead = Lead::where('tracking',$status['payload']['order_id'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'proseccing' , 'status_suivi' => $check]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['status'] = $check;
                    $data['comment'] = $check;
                    HistoryStatu::insert($data);
                }
            }elseif($check == "Reporté"){
                $lead = Lead::where('tracking',$status['payload']['order_id'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'proseccing' , 'status_suivi' => $check]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['status'] = $check;
                    $data['comment'] = $check;
                    HistoryStatu::insert($data);
                }
            }elseif($check == "Intéressé"){
                $lead = Lead::where('tracking',$status['payload']['order_id'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'proseccing' , 'status_suivi' => $check]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['status'] = $check;
                    $data['comment'] = $check;
                    HistoryStatu::insert($data);
                }
            }elseif($check == "Reçu par le livreur"){
                $lead = Lead::where('tracking',$status['payload']['order_id'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'proseccing' , 'status_suivi' => $check]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['status'] = $check;
                    $data['comment'] = $check;
                    HistoryStatu::insert($data);
                }
            }elseif($check == "CANCELED"){
                $lead = Lead::where('tracking',$status['payload']['order_id'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'rejected' , 'status_suivi' => $check]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['status'] = 'rejected';
                    $data['comment'] = 'rejected';
                    HistoryStatu::insert($data);
                }
            }elseif($check == "Refusé"){
                $lead = Lead::where('tracking',$status['payload']['order_id'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'rejected' , 'status_suivi' => $check]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['status'] = $check;
                    $data['comment'] = $check;
                    HistoryStatu::insert($data);
                }
            }
            Log::info($check);
        }
        
        // $orderRef = $request->input('CODE');
       
        // $lead = Lead::where('tracking', $orderRef)->first();
    
        // if (!$lead) {
        //     return response()->json(['message' => 'Lead not found'], 404);
        // }
    
        // $statusMappings = [
        //     'Livré' => 'Delivered',
        //     'Mise en distribution' => 'In transit',
        //     'En cours d\'expédition' => 'In transit',
        //     'Nouveau Colis' => 'Packed',
        //     'Ramassé' => 'Shipped',
        //     'Reçu' => 'Shipped',
        //     'Relancer' => 'Incident',
        //     'Relancer vers un nouveau client' => 'Incident',
        //     'Relancer (Suivé)' => 'Incident',
        //     'Renvoyez vers nouvelle ville' => 'Incident',
        //     'Retourné' => 'Returned',
        //     'Expédié' => 'Incident',
        //     'Attente De Ramassage' => 'Packed',
        //     'Colis non expédiés' => 'Incident'
        // ];

        // if ($status == "En cours") {
        //     $status_suivi = $request->input('STATUS_S_NAME');
        //     $lead->status_livraison = $status;
        //     $lead->status_suivi = $status_suivi;
        // } else {
        //     // $lead->status_livraison = $status;
        //     if (array_key_exists($status, $statusMappings)) {
        //         $lead->status_livraison = $statusMappings[$status];
        //     }
        // }
        
        // $lead->save();
        
        return response()->json(['message' => 'Webhook received'], 200);
    }
}
