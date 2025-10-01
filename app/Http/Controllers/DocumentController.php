<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    //
    public function store(Request $request)
    {
        $data = array();
        $data['id_user'] = $request->id_seller;
        $data['name'] = $request->name;
        if($request->document){
            $file = $request->document;
            $extension = $file->getClientOriginalExtension();
            $filename = time() .'.'.$extension;
            $file->move('uploads/document', $filename);
            $data['document'] = 'https://admin.ecomfulfilment.eu/uploads/document/'.$filename;
        }

        Document::insert($data);

        return back();
    }
}
