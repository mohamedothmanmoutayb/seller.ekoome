<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Countrie;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Auth;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $provinces = Province::with('country')->where('id_country',Auth::user()->country_id);
        if($request->search){
            $provinces = $provinces->where('name','like','%'.$request->search.'%');
        }
        if($request->items){
            $items = $request->items;
        }else{
            $items = 10;
        }
        $provinces = $provinces->paginate($items);
        $countries = Countrie::get();
        return view('backend.provinces.index', compact('provinces','countries','items'));
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
        $data = [
            'id_country' => $request->country,
            'name' => $request->province,
        ];
        Province::insert($data);
        return response()->json(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function show(Province $province)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function edit(Province $province)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Province $province)
    {
        $data = [
            'name' => $request->province,
        ];

        Province::where('id',$request->id)->update($data);
        return response()->json(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function destroy(Province $province , Request $request)
    {
        Province::where('id',$request->id)->delete();
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
                $province = Province::where('name',$sheet->getCell( 'A' . $row )->getValue())->first();
                if(empty($province->name)){
                    if(!empty($sheet->getCell( 'A' . $row )->getValue())){
                        $data = array();
                        $data['id_country'] = $request->country;
                        $data['name'] = $sheet->getCell( 'A' . $row )->getValue();
                        $data['short_name'] = $sheet->getCell( 'B' . $row )->getValue();
                        Province::insert($data);
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


    public function details($id)
    {
        $data = Province::where('id',$id)->first();
        
        $data = json_decode($data);
        return response()->json($data);
    }
}
