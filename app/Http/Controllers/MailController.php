<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\forgets;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function forgerPassword($token,$email){
        $data = [
            'token' => $token,
            ];
        Mail::to($email)->send(new forgets($data));
    }
}
