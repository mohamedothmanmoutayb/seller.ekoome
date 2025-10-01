<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Countrie;
use App\Models\Warehouse;
use App\Models\AgentRole;
use App\Models\Permission;
use App\Models\RoleHasPermission;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        // if(Auth::user()->id_role == 1){
            $users = User::with('role','rol')->where('id_role','!=',2)->where('id_role','!=',11)->where('id_role','!=',10)->where('country_id', Auth::user()->country_id);
            if($request->search){
                $users = $users->where('name','like','%'.$request->search.'%');
            }
            $users = $users->paginate(10);
            $roles = Role::where('id','!=',2)->orWhere('id','!=',11)->orWhere('id','!=',10)->get();
            $countries = Countrie::get();

            $warehouses = Warehouse::where('country_id',Auth::user()->country_id)->get();

        return view('backend.users.index', compact('users','roles','countries','warehouses'));
        // }else{
        //     return redirect()->back();
        // }
        
    }

    public function store(Request $request)
    {
        if(User::where('email',$request->email)->first()){
            return response()->json(['warring'=>false]);
        }else{
            $data = [
                'company' => $request->company,
                'name' => $request->name,
                'telephone' => $request->phone,
                'email' => $request->email,
                'country_id' => $request->country,
                'id_role' => $request->role,
                'is_active' => '1',
                'warehouse_id' => $request->warehouse,
                'password' => Hash::make($request->password),
            ];
            User::insert($data);
            return response()->json(['success'=>true]);
        }
        
    }

    public function edit(Request $request, $id)
    {
        $user = User::where('id',$id)->first();

        return response()->json($user);
    }

    public function inactive(Request $request)
    {
        $data = [
            'is_active' => '0',
        ];
        User::where('id', $request->id)->update($data);
        return response()->json(['success'=>true]);
    }

    public function active(Request $request)
    {
        $data = [
            'is_active' => '1',
        ];
        User::where('id', $request->id)->update($data);
        return response()->json(['success'=>true]);
    }

    public function reset(Request $request)
    {
        $data = [
            'password' => Hash::make(123456),
        ];
        User::where('id',$request->id)->update($data);
        return response()->json(['success'=>true]);
    }

    public function password(Request $request)
    {
        if($request->password == $request->newpassword){
            User::where('id',$request->id)->update(['password' => Hash::make($request->newpassword)]);
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['error'=>false]);
        }
    }
    public function update(Request $request)
    {
        $data = array();
        if($request->user_name){
            $data['name'] = $request->user_name;
        }
        if($request->user_phone){
            $data['telephone'] = $request->user_phone;
        }
        if($request->user_email){
            $data['email'] = $request->user_email;
        }

        User::where('id',$request->user_id)->update($data);

        return back();
    }
    public function profil()
    {
        $user = User::with('rol')->where('id', Auth::user()->id)->get();
        
        $user = $user->first();
        $subscriptions = Subscription::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $allSubscriptions = Subscription::orderBy('created_at', 'desc')
            ->paginate(10);

            
        return view('backend.profile', compact('user','subscriptions','allSubscriptions'));
    }
 
    public function updateprofil(Request $request, User $user)
    {
        if(!empty($request->fullname) && !empty($request->phone)){
            if(!empty($request->newpass)){
                if($request->newpass != $request->conpass){
                    return response()->json(['pass'=>'pass']);
                }else{
                        $data = [
                            'name' => $request->fullname,
                            'company' => $request->company,
                            'telephone' => $request->phone,
                            'rib' => $request->rib,
                            'bank' => $request->bank,
                            'password' => Hash::make($request->newpass),
                        ];
                        User::where('id', Auth::user()->id)->update($data);
                        return route('home');
                    
                }
            }else{
                    $data = [
                        'name' => $request->fullname,
                        'company' => $request->company,
                        'telephone' => $request->phone,
                        'rib' => $request->rib,
                        'bank' => $request->bank,
                    ];
                    User::where('id', Auth::user()->id)->update($data);
                    return route('home');
            }
        }else{
            return response()->json(['success'=> 'remplier']);
        }
    }

    public function updatesprofil(Request $request, User $user)
    {
        if(!empty($request->fullname) && !empty($request->phone)){
            if(!empty($request->newpass)){
                if($request->newpass != $request->conpass){
                    return back();
                }else{
                        $data = [
                            'name' => $request->fullname,
                            'company' => $request->company,
                            'telephone' => $request->phone,
                            'rib' => $request->rib,
                            'bank' => $request->bank,
                            'password' => Hash::make($request->newpass),
                        ];
                        User::where('id', Auth::user()->id)->update($data);
                        return back();
                }
            }else{
                    $data = [
                        'name' => $request->fullname,
                        'company' => $request->company,
                        'telephone' => $request->phone,
                        'rib' => $request->rib,
                        'bank' => $request->bank,
                    ];
                    User::where('id', Auth::user()->id)->update($data);
                    return back();
            }
        }else{
            return back();
        }
    }

    public function document()
    {
        $user = User::with('role')->where('id', Auth::user()->id)->get();
        $user = $user->first();

        $documents = Document::where('id_user', Auth::user()->id)->get();
        return view('backend.document', compact('user','documents'));
    }
}
