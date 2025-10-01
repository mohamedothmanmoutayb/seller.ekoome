<?php

namespace App\Http\Controllers;

use App\Models\Citie;
use App\Models\Province;
use App\Models\Countrie;
use App\Models\ShippingCompany;
use Illuminate\Http\Request;
use App\Models\LastmilleIntegration;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Auth;

class CitieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cities = Citie::with('country')->where('id_country',Auth::user()->country_id);
        if($request->search){
            $cities = $cities->where('name','like','%'.$request->search.'%');
        }
        if($request->items){
            $items = $request->items;
        }else{
            $items = 10;
        }
        $cities = $cities->paginate($items);
        $countries = Countrie::get();
        $provinces = Province::get();
        $shippingcompany = ShippingCompany::get();
        $lastmille = LastMilleIntegration::where('id_country',Auth::user()->country_id)->where('id_user', Auth::user()->id)->select('id_lastmile')->get();

        return view('backend.cities.index', compact('cities','countries','provinces','items','shippingcompany','lastmille'));
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
        $check = Citie::where('name',$request->city)->where('last_mille',$request->company)->first();
        if(empty($check->id)){
            $data = [
                'id_country' => Auth::user()->country_id,
                'name' => $request->city,
                'last_mille' => $request->company,
                'fees_delivered' => $request->delivered,
                'fees_returned' => $request->returned,
            ];
            Citie::insert($data);
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['error'=>false]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Citie  $citie
     * @return \Illuminate\Http\Response
     */
    public function show(Citie $citie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Citie  $citie
     * @return \Illuminate\Http\Response
     */
    public function edit(Citie $citie)
    {
        //
    }


    public function details($id)
    {
        $data = Citie::where('id',$id)->first();
        
        $data = json_decode($data);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Citie  $citie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Citie $citie)
    {
        $data = [
            'name' => $request->city,
            'fees_delivered' => $request->delivered,
            'fees_returned' => $request->returned,
        ];
        Citie::where('id',$request->id)->update($data);
        return response()->json(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Citie  $citie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Citie::where('id',$request->id)->delete();
        return response()->json(['success'=>true]);
    }

    public function upload(Request $request)
    {
        
        /*$this->validate($request, [
            'select_file'  => 'required|mimes:xls,xlsx,csv'
           ]);*/
           
        $the_file  = $request->file('csv_file');
        try{
           $spreadsheet = IOFactory::load($the_file->getRealPath());
           $sheet        = $spreadsheet->getActiveSheet();
           $row_limit    = $sheet->getHighestDataRow();
           $column_limit = $sheet->getHighestDataColumn();
           $row_range    = range( 2, $row_limit );
           $column_range = range( 'A', $column_limit );
           $startcount = 2;
           //dd($row_range);
           foreach ( $row_range as $row ) {
                $province = Citie::where('name',$sheet->getCell( 'A' . $row )->getValue())->first();
                if(empty($province->name)){
                    if(!empty($sheet->getCell( 'A' . $row )->getValue())){
                        $data = array();
                        $data['id_country'] = $request->country;
                        $data['id_province'] = $request->province;
                        $data['name'] = $sheet->getCell( 'A' . $row )->getValue();
                        Citie::insert($data);
                    }
                }
                $startcount++;
            }
        } catch (Exception $e) {
           $error_code = $e->errorInfo[1];
           return back()->withErrors('There was a problem uploading the data!');
        }
       return back()->with('success', 'Excel Data Imported successfully.');
    }

    public function inactive($id)
    {
        Citie::where('id',$id)->update(['is_active' => '0']);

        return back();
    }

    public function active($id)
    {
        Citie::where('id',$id)->update(['is_active' => '1']);

        return back();
    }
}
