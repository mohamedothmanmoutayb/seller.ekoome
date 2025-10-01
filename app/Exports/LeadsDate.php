<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Auth;
use DB;

use Illuminate\Http\Request;

class LeadsDate implements FromCollection, WithHeadings
{
    use Exportable;

    public $leads;

    public function __construct(array $leads)
    {
        $this->leads = $leads;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $lead = Lead::join('lead_products','lead_products.id_lead','leads.id')
                    ->join('products','products.id','lead_products.id_product')
                    ->join('users','users.id','leads.id_user'); 
               
        
        if(!empty($this->leads)){          
            $parts = $this->leads;
            $first_date = $this->leads[0];
            
            if(empty($parts[1])){
               
                if(!empty($parts[0]) && $parts[0] != ','){
                   
                    $lead = $lead->whereDate('leads.created_at',$first_date);
                } 
            }
            else{
                $second_date = $parts[1];//dd($first_date);
                //$id = $this->leads[1];
                $lead = $lead->whereBetween('leads.created_at',[$first_date,$second_date]);
               
            }
        }
        
        $lead = $lead->where('leads.id_country', Auth::user()->country_id)->where('leads.deleted_at',0);
        // if($id){
        //     $lead = $lead->where('livreur_id',$id);
        // }
        // $lead = $lead->select('users.name','id_order','leads.n_lead AS Nlead','products.name AS Product',DB::raw('GROUP_CONCAT(products.sku) as SKU'),'leads.name AS Customer','leads.quantity AS QUANTITY','leads.lead_value AS Prices','leads.city AS City','leads.address AS Address','leads.zipcod AS ZipCod','leads.phone AS Phone1','phone2 AS Phone2','leads.tracking As tracking','leads.status_confirmation AS Confirmation','leads.status_livrison AS Shipping','leads.status_payment AS Payment','leads.created_at AS Created','last_status_change','last_status_delivery',DB::raw('DATEDIFF(leads.last_status_delivery, leads.date_shipped)'),'leads.method_payment')->get();
        $lead = $lead->groupBy('id_order','name','Nlead','leads.name','leads.lead_value' , 'Diff','leads.city', 'leads.address', 'leads.zipcod', 'leads.phone', 'phone2', 'leads.tracking', 'leads.status_confirmation', 'leads.status_livrison', 'leads.status_payment', 'leads.created_at', 'last_status_change', 'last_status_delivery','leads.updated_at', 'method_payment')
                        ->select('users.name as name','id_order','leads.n_lead AS Nlead',DB::raw('GROUP_CONCAT(products.name) as Product'),DB::raw('GROUP_CONCAT(products.sku) as SKU'),'leads.name AS Customer',DB::raw('SUM(lead_products.quantity) AS QUANTITY'),'leads.lead_value AS Prices','leads.city AS City','leads.address AS Address','leads.zipcod AS ZipCod','leads.phone AS Phone1','phone2 AS Phone2','leads.tracking As tracking','leads.status_confirmation AS Confirmation','leads.status_livrison AS Shipping','leads.status_payment AS Payment','leads.created_at AS Created','last_status_change','last_status_delivery',DB::raw('DATE_FORMAT(leads.updated_at,"Y-%m-%d")'),DB::raw('ABS(CASE WHEN DATE_FORMAT(leads.last_status_delivery, "%Y-%m-%d") = DATE_FORMAT(leads.date_shipped, "%Y-%m-%d") THEN "0" ELSE DATEDIFF(leads.date_shipped,leads.last_status_delivery) END) as Diff'),'leads.method_payment')
                        ->get();
        
        return $lead;
    }

    
    public function headings(): array
    {
        return [
            'Seller Name',
            'ID MARKET',
            'ID ORDER',
            'Designation',
            'SKU',
            'Customer Name',
            'Quantity',
            'Price',
            'City',
            'Address',
            'ZipCod',
            'Phone',
            'Phone 2',
            'TRACKING NUMBER ',
            'Status Confiramtion',
            'Status Livrison',
            'Status Payment',
            'Created At',
            'Last Update Confirmation',
            'Last Update Shipping',
            'Last Update',
            'Days',
            'Method Payment',
        ];
    }
}
