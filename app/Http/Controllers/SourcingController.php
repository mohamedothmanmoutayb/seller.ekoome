<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sourcing;
use App\Models\Countrie;
use Illuminate\Http\Request;
use Auth;
use App\Notifications\SourcingState;
class SourcingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $sourcings = Sourcing::with(['seller'])->where('id_country', Auth::user()->country_id)->get();
        $sourcings = Sourcing::get();
        return view('backend.sourcings.index', compact('sourcings'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sourcing  $sourcing
     * @return \Illuminate\Http\Response
     */
    public function show(Sourcing $sourcing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sourcing  $sourcing
     * @return \Illuminate\Http\Response
     */
    public function edit(Sourcing $sourcing, $id)
    {
        $detail = Sourcing::where('id',$id)->first();
        $id = $detail->ref;
        $country = Countrie::where('id', Auth::user()->country_id)->first();
        return view('backend.sourcings.details', compact('detail','country','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sourcing  $sourcing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sourcing $sourcing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sourcing  $sourcing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sourcing $sourcing , $id)
    {
        Sourcing::where('id',$id)->where('status_confirmation','canceled')->delete();

        return back();
    }

    public function statuscon(Request $request)
    {
        if($request->status == "canceled"){
            Sourcing::where('id',$request->id)->update(['status_confirmation' => 'canceled']);
            $user->notify(new SourcingState('canceled'));
            return response()->json(['success'=>true]);
        }else{
            $data = array();
            
            $data['status_confirmation'] = "confirmed";
            $data['unite_price'] = $request->price;
            $data['price'] = $request->price * $request->total;
            $data['total'] = $request->total;
            $sourcing=Sourcing::where('id',$request->id)->update($data);
            $user = User::where('id',$sourcing->id_user)->first();
            $user->notify(new SourcingState('confirmed'));
            return response()->json(['success'=>true]);
        }
    }

    public function statusliv(Request $request)
    {
        Sourcing::where('id',$request->id)->update(['status_livrison' => $request->status]);
        return response()->json(['success'=>true]);
    }

    public function paid(Request $request)
    {
        if(!empty($request->screen)){
            $file = $request->screen;
            $extension = $file->getClientOriginalExtension();
            $filename = time() .'.'.$extension;
            $file->move('uploads/products', $filename);
            $data['image'] = 'https://admin.ecomfulfilment.eu/seller/uploads/payment/'.$filename;
            Sourcing::where('ref',$request->id)->update(['status_payment'=>'paid' , 'document' => $data['image']]);
        }
        return back();
    }
}
