 <?php

namespace App\Http\Controllers;

use App\Models\Countrie;
use App\Models\Product;
use App\Models\MappingStock;
use App\Models\Import;
use App\Models\Upsel;
use App\Models\Stock;
use App\Models\User;
use App\Models\Lead;
use App\Models\LeadProduct;
use App\Exports\ExportProduct;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\CsvImportRequest;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Auth;
use PDF;
use DateTime;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::where('id_role',2)->get();
        $products = Product::with(['imports' => function($query){
            $query->where('imports.id_country',Auth::user()->id_warehouse);
        },'users','lead','stock' => function($query){
            $query->with('mapping');
        }]);
     
        $countries = Countrie::get();
        if(!empty($request->search)){
            $products = $products->where('sku','like','%'.$request->search.'%')->orwhere('name','like','%'.$request->search.'%')->orwhere('link','like','%'.$request->search.'%');
        }
        if(!empty($request->seller_name)){
            $products = $products->where('id_user','like','%'.$request->seller_name.'%');
        }
        if(!empty($request->product_name)){
            $products = $products->where('id',$request->product_name);
        }
        if(!empty($request->link)){
            $products = $products->where('link','like','%'.$request->link.'%');
        }
        if(!empty($request->sku)){
            $products = $products->where('sku','like','%'.$request->sku.'%');
        }
        $products = $products->where('id_country',Auth::user()->country_id)->orderby('id','desc')->paginate(10);
        $suppliers = Supplier::where('country_id',Auth::user()->country_id)->get();
        $product = Product::where('id_country', Auth::user()->country_id)->get();
        $warehouses = Warehouse::where('country_id',Auth::user()->country_id)->get();

        return view('backend.products.index', compact('products','countries','users','product','warehouses','suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sku = substr(strtoupper(Auth::user()->name), 0 , 1).''.substr(strtoupper(Auth::user()->name), -1).'-'.random_int(1000, 9999);
        $data = array();
        $data['id_user'] = Auth::user()->id;
        $data['id_store'] = $request->store;
        $data['id_country'] = Auth::user()->country_id;
        $data['name'] = $request->name_product;
        $data['link'] = $request->link_product;
        $data['sku'] = $sku;
        $data['price'] = $request->price_product;
        $data['price_vente'] = $request->price_product_sale;
        $data['low_stock'] = $request->low_stock;
        $data['description'] = $request->description_product;
        $data['created_at'] = new DateTime();
        //dump($request->hasFile('imaage'));
        if($request->image_product){
            $file = $request->image_product;
            $extension = $file->getClientOriginalExtension();
            $filename = time() .'.'.$extension;
            $file->move('uploads/products', $filename);
            $data['image'] = 'https://www.'.request()->server->get('SERVER_NAME').'/uploads/products/'.$filename;
        }else{
            $data['image'] = 'https://www.'.request()->server->get('SERVER_NAME').'/uploads/products/defaultproduct.png';
        }
        Product::insert($data);


        $last_product = Product::where('sku','=',$sku)->First();
        $data2 = [
            'id_product' => $last_product->id,
            'id_country' => Auth::user()->country_id,
            'warehouse_id' => $request->warehouse,
            'quantity_sent' => $request->quantity_product,
            'shipping_country' => $request->shipping_country,
            'nbr_packages' => $request->nbr_package,
            'expedition_mode' => $request->expidtion_mode,
            'expidtion_date' => $request->date_shipping,
            'name_shipper' => $request->name_transport,
            'phone_shipper' => $request->phone_shipping,
            'created_at' =>new DateTime(),
        ];
        Import::insert($data2);
        return redirect()->back()->with('success', 'The success message!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $leads = Lead::where('id_product',$id)->where('deleted_at',1)->get();
        return view('backend.products.leadProduct', compact('leads'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {//dd($id);
        $product = Product::where('sku', $id)->first();
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = array();
        $data['name'] = $request->product_nam;
        $data['link'] = $request->product_link;
        $data['description'] = $request->description_produc;
        $data['price'] = $request->product_price;
        $data['weight'] = $request->product_weight;
        if(!empty($request->product_image)){
            $file = $request->product_image;
            $extension = $file->getClientOriginalExtension();
            $filename = time() .'.'.$extension;
            $file->move('uploads/products', $filename);
            $data['image'] = 'https://www.'.request()->server->get('SERVER_NAME').'/uploads/products/'.$filename;
            Product::where('id',$request->product_id)->update($data);
            return redirect()->back()->with('success', 'The success message!');
        }else{
            $data['image'] = 'https://www.'.request()->server->get('SERVER_NAME').'/uploads/products/defaultproduct.png';
            Product::where('id',$request->product_id)->update($data);
            return redirect()->back()->with('success', 'The success message!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,Request $request)
    {
        $checkimport = Import::where('id_product',$request->id)->first();
        $checkstock = Stock::where('id_product',$request->id)->first();
        // if(!empty($checkstock->id)){
        //     $mapping = MappingStock::where('id_stock',$checkstock->id)->count();
        //     if($mapping == 0){
        //         Product::where('id',$request->id)->delete();
        //         Import::where('id_product',$request->id)->delete();
        //         Stock::where('id_product',$request->id)->delete();
        //         return response()->json(['success'=>true]);
        //     }else{
        //         return response()->json(['error'=>false]);
        //     }
        // }
        if($checkimport || empty($checkimport)){
            $shipped = LeadProduct::where('id_product',$request->id)->count();
            if($shipped != 0){
                if($shipped > 2){
                    return response()->json(['error'=>false]);
                }  
            }else{
                $leadProducts = LeadProduct::where('id_product',$request->id)->get();
                foreach($leadProducts as $v_lead){
                    Lead::where('id',$v_lead->id_lead)->delete();
                    $v_lead->delete();
                }
                Product::where('id',$request->id)->delete();
                Import::where('id_product',$request->id)->delete();
            }

            return response()->json(['success'=>true]);
        }else{
            return response()->json(['error'=>false]);
        }
    }

    public function imports(Request $request, $id, Import $import)
    {
        /*$imports = Import::with(['products'=> function($query){
            $query->where('sku',$id);
        }])->get();*/
        $imports = Product::with(['imports'=>function($query){
            $query = $query->with('shipping');
        }])->where('sku',$id)->get();
        //dd($stocks);
        return view('backend.imports.index', compact('imports'));
    }

    public function warehousestore(Request $request)
    {
        $data2 = [
            'id_product' => $request->product,
            'id_country' => Auth::user()->country_id,
            'warehouse_id' => $request->warehouse,
            'quantity_sent' => $request->quantity,
            'shipping_country' => $request->country,
            'nbr_packages' => $request->packagin,
            'expedition_mode' => $request->mode,
            'expidtion_date' => $request->date,
            'name_shipper' => $request->expidition,
            'phone_shipper' => $request->phone,
            'created_at' =>new DateTime(),
        ];
        Import::insert($data2);
        
        return response()->json(['success'=>true]);
    }

    public function upsel(Request $request)
    {
        $data = [
            'id_product' => $request->product,
            'quantity' => $request->quantity,
            'discount' => $request->discount,
            'note' => $request->note,
            'created_at' => new DateTime(),
        ];

        Upsel::insert($data);
        return response()->json(['success'=>true]);
    }

    public function upsells(Request $request,$id)
    {
        //$upsells = Upsel::where('id_product',$id)->get();
        $upsells = Product::with('upselles')->where('sku',$id)->get();
        $product = Product::where('sku',$id)->first();
        //dd($upsells);

        return view('backend.products.upsells', compact('upsells','product'));
    }

    public function editupsells($id)
    {
        $upsells = Upsel::where('id',$id)->first();
        return response()->json($upsells);
    }

    public function updateupsells(Request $request)
    {
        $data = [
            'quantity' => $request->quantity,
            'discount' => $request->discount,
            'note' => $request->note,
        ];

        Upsel::where('id',$request->id)->update($data);
        return response()->json(['success'=>true]);
    }

    public function deleteupsells(Request $request)
    {
        Upsel::where('id',$request->id)->delete();
        return response()->json(['success'=>true]);
    }

    public function stocks($id)
    {
        $product = Product::where('sku',$id)->first();
       
        $stocks = Product::join('imports','imports.id_product','products.id')
        ->join('stocks','stocks.id_product','products.id')
        ->where('stocks.id_product',$product->id)
        ->whereIn('imports.status', ['confirmed','confirmed parcial'])
        // ->where('stocks.id_warehouse', Auth::user()->country_id)
        ->select('stocks.id as id','imports.quantity_sent As quantity_sent','imports.quantity_received as quantity_received','imports.quantity_real as quantity_real','stocks.note as note','products.name as name','products.sku as sku','products.image as image','stocks.qunatity as quantity')->get();      
        //dd($stocks);
        return view('backend.products.stocks', compact('stocks'));
    }

    public function importprint(Request $request,$id)
    {
        $imports = Import::with('products','countries')->where('id',$id)->get();
        //dd($imports);
        $customPaper = array(0,0,425,385);
        $ty = Import::where('id',$id)->first();
        $pro = Product::where('id',$ty->id_product)->first();
        $user = User::where('id',$pro->id_user)->first();
        $pdf = PDF::loadView('backend.imports.border', compact('imports','user'))->setPaper($customPaper,'portrait');  
   
        return $pdf->download('import.pdf');
    }

    //update stock

    public function updatestock(Request $request)
    {
        $prodyct = Product::where('sku',$request->id)->first();
        $stock = Stock::where('id_product',$prodyct->id)->first();

        $data = array();
        $data['qunatity'] = $request->quantity;
        $data['isactive'] = 1;
        Stock::where('id',$stock->id)->update($data);

        MappingStock::where('id_stock',$stock->id)->update(['quantity' => $request->quantity , 'isactive' => '1' ]);
        return response()->json(['success'=>true]);
    }

    //list stock mapping

    public function stockmapping($id)
    {
        $mapping = MappingStock::with(['stock','tagier' => function($query){
            $query = $query->with(['palet' => function($query){
                $query = $query->with('row');
            }]);
        }])->where('id_stock',$id)->get();

        //dd($mapping);
        return view('backend.products.mapping', compact('mapping'));
    }

    public function updatestockmapping(Request $request)
    {
        $mapp = MappingStock::where('id',$request->id)->first();
        $data = array();
        $data['quantity'] = $request->quantity;
        $data['isactive'] = 1;
        //dd($request->id);
        MappingStock::where('id',$request->id)->update($data);

        $sum = MappingStock::where('id_stock',$mapp->id_stock)->sum('quantity');
        //dd($sum);
        Stock::where('id',$mapp->id_stock)->update(['qunatity'=>$sum , 'isactive'=> 1]);
        return response()->json(['success'=>true]);
    }

    public function export(Request $request){
        //dd($request->all());
        $ids = $request->ids;
        foreach($ids as $v_id){
            $leads[] = Product::whereIn('id',explode(",",$v_id))->get();
        }
    }

    public function download(Request $request,$leads)
    {
        $leads = json_decode($leads);
        $leads = new ExportProduct([$leads]);
        return Excel::download($leads, 'Product.xlsx');
    }

}
