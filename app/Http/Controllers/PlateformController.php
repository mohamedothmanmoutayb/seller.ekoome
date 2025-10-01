<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlateformController extends Controller
{
    public function index(){
        
        return view('backend.plateformes.index');
    }
}
