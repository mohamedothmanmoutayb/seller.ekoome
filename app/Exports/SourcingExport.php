<?php

namespace App\Exports;

use App\Models\Sourcing;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SourcingExport implements FromCollection
{
    use Exportable;

    protected $orders;
    public function __construct(array $orders)
    {
        $this->orders = $orders;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        foreach($this->orders as $v_order){
            $order = Sourcing::whereIn('id',$v_order)->get();
        }
        
       //dd($lead);
        return $order;
    }
}
