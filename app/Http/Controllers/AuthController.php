<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\TblUser;
use Validator;



	
class AuthController extends Controller
{
    function createnew(){

        return view('admin.createuser');
    }

    function login(){

    	return view('auth.login');
    }

    function register(){

    	return view('auth.register');
    }

    function save(Request $request){

    	//return $request->input();
    	// validate request
    	
    	$request->validate([

    		'name'=>'required',
    		'email'=>'required|unique:tbl_users,user_email',
    		'password'=>'required|min:5|max:12'
// |unique:tbl_users,user_email

    	]);

    	//dd($request->input());
        
        $user =  TblUser::create([

                "user_email"            =>          $request->email,
                "user_password"            =>       Hash::make($request->password)

            ]);
        if($user){

            return back()->with("success", "Success! User Created Successfully");
        }else{

            return back()->with("fail", "Failed! Try after some time");
        }
        

    }

    function check(Request $request){

    	$request->validate([

    		'email'=>'required|email',
    		'password'=>'required|min:5|max:12'


    	]);

    	//return $request;
        $userInfo = TblUser::where('Email','=', $request->email)->first();
        //print_r($userInfo);
        //dd($userInfo->Id );
        if(!$userInfo){
            return back()->with('fail','We do not recognize your email address');
        }else{
            //check password
            if(Hash::check($request->password, $userInfo->Password)){
                $request->session()->put('LoggedUser', $userInfo->Id);
                return redirect('admin/dashboard');
                

            }else{
                return back()->with('fail','Incorrect password');
            }
        }
    }

    function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('/auth/login');
        }
    }
    
    function dashboard(){
        $data = ['LoggedUserInfo'=>TblUser::where('id','=', session('LoggedUser'))->first()];
        return view('admin.dashboard', $data);
        
    }
    function adddriverdb(){
        $data = ['LoggedUserInfo'=>TblUser::where('id','=', session('LoggedUser'))->first()];
        // return view('admin.add_driver',$data);
        return view('admin.dashboard', $data);
    }
}
