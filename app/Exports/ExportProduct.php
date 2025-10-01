<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Illuminate\Http\Request;

class ExportProduct implements FromCollection, WithHeadings
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
            $lead = Product::join('stocks','stocks.id_product','products.id')->join('users','users.id','products.id_user')->whereIn('products.id',$v_lead)->where('stocks.isactive',1)->select('users.name as seller','products.name as product','products.sku as sku',\DB::raw('SUM(stocks.qunatity) As qunatity'),'products.created_at')->groupby('qunatity','users.name','products.name','products.sku','products.created_at')->get();
        }//dd('uu');
        return $lead;
    }

    
    public function headings(): array
    {
        return [
            'Seller',
            'Product Name',
            'Product Sku',
            'Quantity Live',
            'Created At',
        ];
    }
}
