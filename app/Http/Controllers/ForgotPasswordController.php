<?php 

namespace App\Http\Controllers; 

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon; 

class ForgotPasswordController extends Controller
{
  public function getEmail()
  {

     return view('auth.password');
  }

 public function postEmail(Request $request)
  {

      $token = Str::random(64);

      DB::table('password_resets')->insert(
          ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
      );
      /*dd('yyy');
      Mail::send('auth.verify', ['token' => $token], function($message) use($request){
          $message->to($request->email);
          $message->subject('Reset Password Notification');
      });*/
      $user = User::where('email',$request->email)->first();
      if(User::where('email',$request->email)->first()){
          $email = $request->email;
      MailController::forgerPassword($token,$email);
      }
      

      return back()->with('message', 'We have e-mailed your password reset link!');
  }
}