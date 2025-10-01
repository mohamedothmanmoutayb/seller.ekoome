<?php

namespace App\Http\Controllers;

use App\Models\Zipcode;
use App\Models\Countrie;
use Illuminate\Http\Request;
use App\Models\IslandZipcode;
use App\Models\MenorIslande;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Auth;

class ZipcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countries = Countrie::get();
        $zipcodes = Zipcode::with('country')->where('id_country', Auth::user()->country_id);
        if($request->search){
            $zipcodes = $zipcodes->where('name','like','%'.$request->search.'%');
        }
        if($request->items){
            $items = $request->items;
        }else{
            $items = 10;
        }
        $zipcodes = $zipcodes->paginate($items);

        return view('backend.zipcode.index', compact('zipcodes','countries','items'));
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
        $data = array();
        $data['id_country'] = $request->country;
        $data['name'] = $request->zipcode;

        Zipcode::insert($data);
        return response()->json(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zipcode  $zipcode
     * @return \Illuminate\Http\Response
     */
    public function show(Zipcode $zipcode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zipcode  $zipcode
     * @return \Illuminate\Http\Response
     */
    public function edit(Zipcode $zipcode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zipcode  $zipcode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zipcode $zipcode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zipcode  $zipcode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Zipcode::where('id',$request->id)->delete();
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
                $province = Zipcode::where('name',$sheet->getCell( 'A' . $row )->getValue())->first();
                if(empty($province->name)){
                    if(!empty($sheet->getCell( 'A' . $row )->getValue())){
                        $data = array();
                        $data['id_country'] = $request->country;
                        $data['name'] = $sheet->getCell( 'A' . $row )->getValue();
                        Zipcode::insert($data);
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

    public function island(Request $request)
    {
        $countries = Countrie::get();
        $zipcodes = IslandZipcode::with('country')->where('id_country', Auth::user()->country_id);
        
        if($request->search){
            $zipcodes = $zipcodes->where('name','like','%'.$request->search.'%');
        }
        if($request->items){
            $items = $request->items;
        }else{
            $items = 10;
        }
        $zipcodes = $zipcodes->paginate($items);
        return view('backend.zipcode.island', compact('zipcodes','countries','items'));
    }

    public function uploadisland(Request $request)
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
                $province = IslandZipcode::where('name',$sheet->getCell( 'A' . $row )->getValue())->first();
                if(empty($province->name)){
                    if(!empty($sheet->getCell( 'A' . $row )->getValue())){
                        $data = array();
                        $data['id_country'] = $request->country;
                        $data['zipcode'] = $sheet->getCell( 'A' . $row )->getValue();
                        IslandZipcode::insert($data);
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

    public function storeisland(Request $request)
    {
        $data = array();
        $data['id_country'] = $request->country;
        $data['zipcode'] = $request->zipcode;

        IslandZipcode::insert($data);
        return response()->json(['success'=>true]);
    }

    //menor islande

    public function menorisland(Request $request)
    {
        $countries = Countrie::get();
        $zipcodes = MenorIslande::with('country')->where('id_country', Auth::user()->country_id);
        
        if($request->search){
            $zipcodes = $zipcodes->where('name','like','%'.$request->search.'%');
        }
        if($request->items){
            $items = $request->items;
        }else{
            $items = 10;
        }
        $zipcodes = $zipcodes->paginate($items);
        return view('backend.zipcode.menor', compact('zipcodes','countries','items'));
    }

    public function menorstoreisland(Request $request)
    {
        $data = array();
        $data['id_country'] = $request->country;
        $data['zipcode'] = $request->zipcode;

        MenorIslande::insert($data);
        return response()->json(['success'=>true]);
    }

    public function menoruploadisland(Request $request)
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
                $province = MenorIslande::where('name',$sheet->getCell( 'A' . $row )->getValue())->first();
                if(empty($province->name)){
                    if(!empty($sheet->getCell( 'A' . $row )->getValue())){
                        $data = array();
                        $data['id_country'] = $request->country;
                        $data['zipcode'] = $sheet->getCell( 'A' . $row )->getValue();
                        MenorIslande::insert($data);
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
}
