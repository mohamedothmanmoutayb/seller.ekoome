<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OzonexpressWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Ozonexpress Webhook:', $request->all());
        
        $status = json_decode($request->getContent(), true);
        if(!empty($status['payload']['status'])){
            $check = $status['payload']['status'];
            if($check == "DELIVERED"){
                $lead = Lead::where('tracking',$status['payload']['order_id'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'delivered']);
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
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'rejected']);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['status'] = "rejected";
                    $data['comment'] = "rejected";
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
            }
            Log::info($check);
        }
        
        
        return response()->json(['message' => 'Webhook received'], 200);
    }
    
}
