<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Items;
class testController extends Controller
{
	public function index(Request $request)
	{
		$objItems = new Items;
		$detailsright =  $objItems::where('position',1)->get();
		$detailsrleft =  $objItems::where('position',2)->get();
		return view('test.index',compact('detailsright','detailsrleft'));
	}
	public function saveitem(Request $request)
	{
		$objItems = new Items;
		$objItems->item_name=$request->value;
		if($objItems->save())
		{
			return 1;
		}
	}
	public function change(Request $request)
	{
		$objItems = Items::find($request->item);
		$objItems->position=$request->position;
		if($objItems->save())
		{
			return 1;
		}
	}
	
}
?>