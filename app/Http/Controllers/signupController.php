<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserSignup1VerifyRequest;
use App\Http\Requests\UserSignup2VerifyRequest;

use Illuminate\Support\Facades\DB;
use App\User;
use App\Address;


class signupController extends Controller
{
    public function Index1()
    {
    	return view('userSignup1');
    }
    
    public function Posted1(UserSignup1VerifyRequest $request)
    {
       /* $address = new Address();
        $address->area = $request->Area;
        $address->city = $request->City;
        $address->zip = $request->Zip;
        

        $address->save();
        $id = $this->create($address)->id;
        session()->flash('temp_address_id', $id);*/
        
        
        $id = DB::table('addresses')->insertGetId(
                [ 'area' => $request->Area, 'city' => $request->City,'zip' => $request->Zip ]
                );
        
        
        return redirect()->route('user.signup.continue', ['address_id' => $id]);


        
    }
    
    public function Index2()
    {
    	return view('userSignup2');
    }
    
    
    public function Posted2(UserSignup2VerifyRequest $request,$address_id)
    {      

        $user = new User();
        $user->full_name = $request->Full_name;
        $user->email = $request->Email;
        $user->password = $request->Password;
        
        $user->address_id = $address_id;
        
        $user->phone = $request->Phone;

        if($user->save())
            
        {
            return redirect()->route('user.login');
        }
        else{
            $addressToDelete = Address::find($address_id);
        $addressToDelete->delete();
        }
        
        
    }
}
