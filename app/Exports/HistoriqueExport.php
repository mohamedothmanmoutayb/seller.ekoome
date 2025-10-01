<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistoriqueExport implements FromCollection
{
    use Exportable;

    protected $leads;
    public function __construct(array $leads)
    {
        $this->leads = $leads;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        foreach($this->leads as $v_lead){
            $lead = Lead::with('products')->whereIn('id',$v_lead)->get();
        }
        
       //dd($lead);
        return $lead;
    }
}
