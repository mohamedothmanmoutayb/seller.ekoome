<?php

namespace App\Http\Controllers;

use App\Models\MediaGallery;
use App\Models\MediaVideo;
use App\Models\{Product, Requests, SubCategory,Category,Stock,User,Countrie};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function index(Request $request){

        $bool = false;
        $query = Product::with(['category','users'])
                ->where('status', 'active') 
                ->whereHas('users', function ($query) {
                    $query->where('id_role', '10');
                })->where('type','affiliate')->where('id_country',Auth::user()->country_id);
        $users = User::where('id_role',10)->get();

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

        $products = $query->latest()->paginate(15);
        $categories = Category::with('subcategories')->get();
        $products = Product::with(['category','users'])
                ->where('status', 'active') 
                ->whereHas('users', function ($query) {
                    $query->where('id_role', '10');
                })->where('type','affiliate')->where('id_country',Auth::user()->country_id)->latest()->paginate(15);
     
        $product = Product::where('type','affiliate')->where('id_country', Auth::user()->country_id)->whereHas('users', function ($query) {
            $query->where('id_role', '10');
        })->get();
        $countries = Countrie::get();
        return view('backend.offers.index',compact('products','categories','product','countries','users'));
    }

    public function details($id){
        $bool = false;
        $product = Product::with('category','stock','users')->findOrfail($id);
        if($product->status == 'inactive'){
           $bool = true;
        }
        $user = User::where('id',$product->id_user)->select('name','email','telephone')->first();
        $request = Requests::where('id_user',Auth::user()->id)
                    ->where('id_product',$product->id)
                    ->where('is_active',1)->latest()->count();       

        $videos = MediaVideo::where('id_product',$product->id)->get();
        $photos = MediaGallery::where('id_product',$product->id)->get();
       

        return view('backend.offers.details',compact('product','request','videos','photos','user','bool'));
    }

    public function pendingOffers(Request $request){

        $bool = true;
        $query = Product::with(['category','users'])
                ->where('status', 'inactive') 
                ->whereHas('users', function ($query) {
                    $query->where('id_role', '10');
                })
                ->where('id_country',Auth::user()->country_id);

        if ($request->has('search')) {
            $searchTerm = $request->search;

            $query->where(function ($subquery) use ($searchTerm) {
                $subquery->whereHas('category', function ($categorySubquery) use ($searchTerm) {
                    $categorySubquery->where('name', 'like', '%' . $searchTerm . '%');
                })->orWhere('name', 'like', '%' . $searchTerm . '%')->orWhere('price', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->has('category')) {
            $categorySearchTerm = $request->input('category');
            $query->whereHas('category', function ($categorySubquery) use ($categorySearchTerm) {
                $categorySubquery->where('id', 'like', '%' . $categorySearchTerm . '%');
            });
        }

        if ($request->has('subcategory')) {
            $subcategorySearchTerm = $request->input('subcategory');
            $query->where('id_subcategory', 'like', '%' . $subcategorySearchTerm . '%');
        }

        if ($request->has('name')) {
            $nameSearchTerm = $request->input('name');
            $query->where('name', 'like', '%' . $nameSearchTerm . '%');
        }

        if ($request->has('price')) {
            $priceSearchTerm = $request->input('price');
            $query->where('price', 'like', '%' . $priceSearchTerm . '%');
        }

        $products = $query->latest()->paginate(15);
        $categories = Category::with('subcategories')->get();
     
      
        
        return view('backend.offers.pending')->with('products', $products)->with('categories',$categories)->with('bool',$bool);
    }


    public function acceptOffer(Request $request){
        $product = Product::findOrfail($request->id);
        $product->status = 'active';
        $product->save();

        return redirect()->back()->with('success','Offer has been accepted');
    }

    public function deactivateOffer(Request $request){
        $product = Product::findOrfail($request->id);
        $product->status = 'inactive';
        $product->save();

        return redirect()->back()->with('success','Offer has been desactivated');
    }

    public function update(Request $request, Product $product)
    {
        $data = array();
        $data['name'] = $request->product_nam;
        $data['link'] = $request->product_link;
        $data['description'] = $request->description_produc;
        $data['price_vente'] = $request->product_price;
        $data['price_service'] = $request->product_fees;
        $data['offer_price'] = $request->product_offer;
        $data['is_fixed_price'] = $request->product_status;

        $data['weight'] = $request->product_weight;
        if(!empty($request->product_image)){
            $file = $request->product_image;
            $extension = $file->getClientOriginalExtension();
            $filename = time() .'.'.$extension;
            $file->move('uploads/products', $filename);
            Product::where('id',$request->product_id)->update($data);
            return redirect()->back()->with('success', 'The success message!');
        }else{
            Product::where('id',$request->product_id)->update($data);
            return redirect()->back()->with('success', 'The success message!');
        }
    }
}
