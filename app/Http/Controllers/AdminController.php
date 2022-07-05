<?php

namespace App\Http\Controllers;
use App\Models\TblDriver;
use App\Models\TblArea;
use App\Models\TblUser;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    function createnew(){
        $data = ['LoggedUserInfo'=>TblUser::where('id','=', session('LoggedUser'))->first()];
        return view('admin.createuser',$data);
    }

    function adddriver(){
        $data = ['LoggedUserInfo'=>TblUser::where('id','=', session('LoggedUser'))->first()];
        return view('admin.add_driver',$data);
    }

    function adddriverdb(Request $request){
        $data = ['LoggedUserInfo'=>TblUser::where('id','=', session('LoggedUser'))->first()];
        $created = $data['LoggedUserInfo']->Email;
        $request->validate([

    		'email'=>'required|unique:tbl_user,Email',

    	]);

        $dat = TblDriver::orderBy('id', 'DESC')->first();
        $cid = $dat->Id  + 1 ;
        $customerid = $request->fname.'00'.$cid;
        $mytime = Carbon::now();
        $mytime = $mytime->toDateTimeString();
        //dd($request->input());
        $sql =  TblDriver::create([

            "DriverID"            =>          $customerid,
            "CustomerID"            =>        $customerid,
            "FirstName"            =>         $request->fname,
            "LastName"            =>        $request->lname,
            "PagerNumber"            =>        $request->pno,
            "Phone"            =>        $request->phno,
            "Mobile"            =>        $request->mobno,
            "Email"            =>        $request->email,
            "Gst_no"            =>        $request->gst,
            "StreetAddress1"            =>        $request->sadr1,
            "StreetAddress2"            =>        $request->sadr2,
            "StreetArea"            =>        $request->area,
            "Company_Driver"        =>        'no',
            "Status"            =>        $request->stat,
            "WhoCreated"            =>        $created,
            "DateCreated"            =>       $mytime,
            
            

        ]);
        if($sql){
            echo $last_id = $sql->id;
            $sql =  TblUser::create([

                "cid "            =>          $last_id,
                "CustomerID"            =>        $customerid,
                "Email"            =>        $request->email,
                "Password"            =>        Hash::make($customerid),
                "Firstname"            =>         $request->fname,
                "Lastname"            =>        $request->lname,
                "Status"            =>        $request->stat,
                "User_role"            =>        'driver',
                "Created_at"            =>       $mytime,
                "WhoModified"            =>        $mytime,
                "Updated_at"            =>        $mytime
                
    
            ]);

            if($sql){

                return back()->with("success", "Success! Driver Created Successfully");
            }else{
    
                return back()->with("fail", "Failed! Try after some time");
            }
        }
    }

    function viewdriver(){
        $data = ['LoggedUserInfo'=>TblUser::where('id','=', session('LoggedUser'))->first()];
        $dat = TblDriver::get();
        return view('admin.view_driver',$data);
    }

    function addarea(){
        $data = ['LoggedUserInfo'=>TblUser::where('id','=', session('LoggedUser'))->first()];
        return view('admin.add_area',$data);
    }

    function addareadb(Request $request){
        $data = ['LoggedUserInfo'=>TblUser::where('id','=', session('LoggedUser'))->first()];
        // $created = $data['LoggedUserInfo']->Email;
        // $request->validate([

    	// 	'email'=>'required|unique:tbl_user,Email',

    	// ]);
        $sql =  TblArea::create([

            "Area"            =>          $request->area,
            "Zone"            =>        $request->zone,
            
            "Status"            =>         $request->stat,
            
        ]);
        

        if($sql){

            return back()->with("success", "Success! Area Created Successfully");
        }else{
    
            return back()->with("fail", "Failed! Try after some time");
        }
        
    }
}
