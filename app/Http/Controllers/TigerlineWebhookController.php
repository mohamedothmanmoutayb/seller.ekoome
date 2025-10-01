<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Stock;
use App\Models\LeadProduct;
use App\Models\MappingStock;
use App\Models\HistoryStatu;
use App\Models\LastmilleIntegration;
use Illuminate\Support\Facades\Log;

class TigerlineWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('TigerLine Webhook:', $request->all());
        
        $v = $request->all();
        $statut = $v['statut'];
        if(!empty($statut)){
            $check = $statut;
            if($check == "DELIVERED"){
                $lead = Lead::where('tracking',$v['parcel_code'])->where('status_livrison','!=','delivered')->first();
                if(!empty($lead->id)){
                    $lastmille = LastmilleIntegration::where('id_user',$lead->id_user)->where('id_country', $lead->id_country)->first();
                    $feesdelivered = $lastmille->fees_delivered;
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'delivered' , 'fees_livrison' => $feesdelivered]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['country_id'] = $lead->country_id;
                    $data['type'] = 'shipping';
                    $data['status'] = "delivered";
                    $data['comment'] = "delivered";
                    HistoryStatu::insert($data);
                }
            }elseif($check == "PICKUP"){
                $lead = Lead::where('tracking',$v['parcel_code'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'shipped']);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['country_id'] = $lead->country_id;
                    $data['type'] = 'shipping';
                    $data['status'] = "shipped";
                    $data['comment'] = "shipped";
                    HistoryStatu::insert($data);
                }
            }elseif($check == "RETURNED"){
                $lead = Lead::where('tracking',$v['parcel_code'])->where('status_livrison','!=','returned')->first();
                if(!empty($lead->id)){
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
                    $data['country_id'] = $lead->country_id;
                    $data['type'] = 'shipping';
                    $data['status'] = "returned";
                    $data['comment'] = "returned";
                    HistoryStatu::insert($data);
                }
            }elseif($check == "TRANSIT"){
                $lead = Lead::where('tracking',$v['parcel_code'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'in transit']);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['country_id'] = $lead->country_id;
                    $data['type'] = 'shipping';
                    $data['status'] = "in transit";
                    $data['comment'] = "in transit";
                    HistoryStatu::insert($data);
                }
            }elseif($check == "PICKEDUP" || $check == "INHOUSE"){
                $lead = Lead::where('tracking',$v['parcel_code'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'in delivery']);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['country_id'] = $lead->country_id;
                    $data['type'] = 'shipping';
                    $data['status'] = "in delivery";
                    $data['comment'] = "in delivery";
                    HistoryStatu::insert($data);
                }
            }elseif($check == "ENROUTE"){
                $lead = Lead::where('tracking',$v['parcel_code'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'in delivery']);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['country_id'] = $lead->country_id;
                    $data['type'] = 'shipping';
                    $data['status'] = "in delivery";
                    $data['comment'] = "in delivery";
                    HistoryStatu::insert($data);
                }
            }elseif($check == "INTERESTED"){
                $lead = Lead::where('tracking',$v['parcel_code'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'proseccing' , 'status_suivi' => $check]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['country_id'] = $lead->country_id;
                    $data['type'] = 'shipping';
                    $data['status'] = $check;
                    $data['comment'] = $check;
                    HistoryStatu::insert($data);
                }
            }elseif($check == "SCHEDULED"){
                $lead = Lead::where('tracking',$v['parcel_code'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'proseccing' , 'status_suivi' => $check]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['country_id'] = $lead->country_id;
                    $data['type'] = 'shipping';
                    $data['status'] = $check;
                    $data['comment'] = $check;
                    HistoryStatu::insert($data);
                }
            }elseif($check == "REPORTED"){
                $lead = Lead::where('tracking',$v['parcel_code'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'proseccing' , 'status_suivi' => $check]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['country_id'] = $lead->country_id;
                    $data['type'] = 'shipping';
                    $data['status'] = $check;
                    $data['comment'] = $check;
                    HistoryStatu::insert($data);
                }
            }elseif($check == "POSTPONED"){
                $lead = Lead::where('tracking',$v['parcel_code'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'proseccing' , 'status_suivi' => $check]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['country_id'] = $lead->country_id;
                    $data['type'] = 'shipping';
                    $data['status'] = $check;
                    $data['comment'] = $check;
                    HistoryStatu::insert($data);
                }
            }elseif($check == "CANCELED"){
                $lead = Lead::where('tracking',$v['parcel_code'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'proseccing' , 'status_suivi' => $check]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['country_id'] = $lead->country_id;
                    $data['type'] = 'shipping';
                    $data['status'] = $check;
                    $data['comment'] = $check;
                    HistoryStatu::insert($data);
                }
            }elseif($check == "REFUSE"){
                $lead = Lead::where('tracking',$v['parcel_code'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'proseccing' , 'status_suivi' => $check]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['country_id'] = $lead->country_id;
                    $data['type'] = 'shipping';
                    $data['status'] = $check;
                    $data['comment'] = $check;
                    HistoryStatu::insert($data);
                }
            }elseif($check == "NOANSWER"){
                $lead = Lead::where('tracking',$v['parcel_code'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'proseccing' , 'status_suivi' => $check]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['country_id'] = $lead->country_id;
                    $data['type'] = 'shipping';
                    $data['status'] = $check;
                    $data['comment'] = $check;
                    HistoryStatu::insert($data);
                }
            }elseif($check == "BV"){
                $lead = Lead::where('tracking',$v['parcel_code'])->first();
                if($lead){
                    Lead::where('id',$lead->id)->update(['status_livrison' => 'proseccing' , 'status_suivi' => $check]);
                    $data = array();
                    $data['id_lead'] = $lead->id;
                    $data['country_id'] = $lead->country_id;
                    $data['type'] = 'shipping';
                    $data['status'] = $check;
                    $data['comment'] = $check;
                    HistoryStatu::insert($data);
                }
            }
        }
        
        return response()->json(['message' => 'Webhook received'], 200);
    }
}
