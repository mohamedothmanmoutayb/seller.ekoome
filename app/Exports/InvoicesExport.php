<?php

namespace App\Exports;

use App\Models\Lead;
use App\Models\Invoice;
use App\Models\LeadInvoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Illuminate\Http\Request;

class InvoicesExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $id;
    public function __construct(array $id)
    {
        $this->id = $id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
            foreach($this->id as $item => $v_id){
                //dd($v_id[$item]);
                $invoices = LeadInvoice::join('invoices','invoices.id','lead_invoices.id_invoice')->join('leads','leads.id','lead_invoices.id_lead')->join('lead_products','lead_products.id_lead','leads.id')->join('products','products.id','lead_products.id_product')->join('users','users.id','leads.id_user')->where('invoices.id',$v_id[$item])->select('n_lead AS Nlead','invoices.ref As Ref','users.name AS Vendor','leads.name AS Customer','products.name AS Product','leads.note As Note','lead_products.lead_value AS Prices','leads.city AS City','leads.address','phone AS Phone1','leads.phone2 AS Phone2','leads.status_confirmation AS Confirmation','leads.status_livrison AS Shipping','leads.status_payment AS Payment','leads.date_delivred AS Date_Delivred','leads.created_at AS Created')->get();
            }//dd($invoices);
        
        return $invoices;
    }

    
    public function headings(): array
    {
        return [
            'N Lead',
            'N Invoice',
            'Vendor Name',
            'Customer Name',
            'Product Name',
            'Note',
            'Price',
            'City',
            'Address',
            'Phone',
            'Phone 2',
            'Status Confiramtion',
            'Status Livraison',
            'Status Payment',
            'Date Shipping',
            'Created At',
        ];
    }
}
