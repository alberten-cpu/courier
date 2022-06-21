<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use DB;
use App\Models\TblUser;
use Validator;



	
class AuthController extends Controller
{

    function login(){

    	return view('auth.login');
    }

    function admindashboard(){

        return view('admin.dashboard');
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
        if(!$userInfo){
            return back()->with('fail','We do not recognize your email address');
        }else{
            //check password
            if(Hash::check($request->password, $userInfo->Password)){
                $request->session()->put('LoggedUser', $userInfo->id);
                return redirect('admin/dashboard');

            }else{
                return back()->with('fail','Incorrect password');
            }
        }
    }
}
