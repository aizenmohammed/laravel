<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Registration;
class registrationController extends Controller
{
    public function index(Request $request)
	{
		
		$registration = new Registration();
		$arr = $registration->find($request->id);
		if(isset($arr))
		return response()->json($arr);
	    else
			return response()->json([
                'message' => 'No data found'
            ], 401);
	}
	public function deleteitem(Request $request)
	{
		
		$registration = new Registration();
		$arr = $registration->where('id',$request->id)->delete();
		return response()->json($arr);
	}
}
