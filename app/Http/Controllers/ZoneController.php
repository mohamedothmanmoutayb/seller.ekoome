<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Models\Countrie;
use Illuminate\Http\Request;
use Auth;

class ZoneController extends Controller
{
    public function index(Request $request)
    {
        $countries = Countrie::get();
        $zones = Zone::with('city');
        if($request->search){
            $zones = $zones->where('name','like','%'.$request->search.'%');
        }
        if($request->items){
            $items = $request->items;
        }else{
            $items = 10;
        }
        $zones = $zones->paginate($items);
        return view('backend.zones.index', compact('zones','countries','items'));
    }

    public function store(Request $request)
    {
        $data = [
            'id_city' => $request->cities,
            'name' => $request->zone,
        ];
        Zone::insert($data);
        return response()->json(['success'=>true]);
    }

    public function destroy(Request $request)
    {
        Zone::where('id',$request->id)->delete();
        return response()->json(['success'=>true]);
    }
}
