<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Users;
class adminController extends Controller
{
   public function login(Request $request)
   {
	  
	   
		return view('login');
	   
   }
   public function loginUser(Request $request)
   {
	    $this->validate(request(),[
		   'user'=>'required|regex:/(^([a-zA-z]+)(\d+)?$)/u',
		   'password'=>'required|regex:/(^([a-zA-z]+)(\d+)?$)/u'
		   ],
		   [
		   'user.required'=>'Please enter username',
		   'password.required'=>'Please enter password'
		   ]
		   );
		   $objUsers = new Users();
		   $username = request('user');
		   $password = request('password');
		   $count    = $objUsers->where([['username',$username],['password',$password]])->count();
		   if($count>0)
		   {
			   
			   return redirect('invoices');
			   
		   }
		   else
		   {
			   $request->session()->flash('REG-MSG','No valid data!');
			   return view('login');
		   }
		   
		   
	   
	   
   }
   
  
}
