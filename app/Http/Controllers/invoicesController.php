<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Invoices;
use App\Invoicedetails;
class invoicesController extends Controller
{
   public function index(Request $request)
   {
	  $objInvoices = new Invoices();
	  $noofitems=10;
		if(isset($request->pagesize))
		{
			
			$pagesize=$request->pagesize;
			$start     = ($pagesize-1)*$noofitems;
		}
		else
		{
			$pagesize=1;
			$start     = 0;
			
		}
	  $invoiceArrT = $objInvoices->where('status',1)->get();
	  $invoiceArr = $objInvoices->where('status',1)->offset($start)->take($noofitems)->get()->sortBy('id');
	  return view('invoice.index',compact('invoiceArrT','invoiceArr','pagesize','noofitems'));
   }
  public function add(Request $request)
  {
	  return view('invoice.add');  
  }
  public function save(Request $request)
  {
	  $this->validate(request(),[
		   'cust_name'=>'required|regex:/(^([a-zA-z ]+)(\d+)?$)/u',
		   'cust_phone'=>'required|numeric',
		   'cust_email'=>'required|email',
		   'cust_address'=>'required|regex:/(^([a-zA-z ]+)(\d+)?$)/u',
		   'item_name.*'=>'required|regex:/(^([a-zA-z ]+)(\d+)?$)/u',
		   'item_desc.*'=>'required|regex:/(^([a-zA-z ]+)(\d+)?$)/u',
		   'item_price.*'=>'required|numeric',
		   'item_qty.*'=>'required|numeric',
		   ],
		   [
		   'cust_name.required'=>'Please enter customer name',
		   'cust_phone.required'=>'Please enter customer phone',
		   'cust_email.required'=>'Please enter customer email',
		   'cust_address.required'=>'Please enter address'
		   ]
		   );
		   
			$objInvoices = new Invoices();
			$objInvoices->cust_name = request('cust_name');
			$objInvoices->cust_phone = request('cust_phone');
			$objInvoices->cust_address = request('cust_address');
			$objInvoices->cust_email = request('cust_email');
			$objInvoices->inv_total = request('total_amount');
			$objInvoices->inv_discount = request('discount');
			$objInvoices->inv_vat = request('vat');
			$objInvoices->inv_grand_total = request('grand_total');
			if($objInvoices->save())
			{
				$id=$objInvoices->id;
				for($i=0;$i<count($_POST["item_name"]);$i++)
				{
					$objInvoicesdetilas = new Invoicedetails();
					$objInvoicesdetilas->invoice_id=$id;
					$objInvoicesdetilas->item_name=request('item_name')[$i];
					$objInvoicesdetilas->item_desc=request('item_desc')[$i];
					$objInvoicesdetilas->item_price=request('item_price')[$i];
					$objInvoicesdetilas->item_qty=request('item_qty')[$i];
					$objInvoicesdetilas->item_total=request('total')[$i];
					$objInvoicesdetilas->save();
				}
				return redirect('invoices');
			}
			
			
  }
  
  public function details(Request $request)
  {
	  
	       $objInvoices = new Invoices();
	       $invoiceArr= $objInvoices->where([['status',1],['id',$request->id]])->first();
		   return view('invoice.details',compact('invoiceArr'));
  }
  public static function getInvoicedetails($id)
  {
	  $objInvoicesdetails = new Invoicedetails();
	  $invoicedetails     = $objInvoicesdetails->where('invoice_id',$id)->get();
	  return $invoicedetails;
  }
  public function edit(Request $request)
  {
	       $request->session()->put('inv_id',$request->id);
	       $objInvoices = new Invoices();
	       $invoiceArr= $objInvoices->where([['status',1],['id',$request->id]])->first();
		   return view('invoice.edit',compact('invoiceArr'));
  }
  public function saveedit(Request $request)
  {
	  $this->validate(request(),[
		   'cust_name'=>'required|regex:/(^([a-zA-z ]+)(\d+)?$)/u',
		   'cust_phone'=>'required|numeric',
		   'cust_email'=>'required|email',
		   'cust_address'=>'required|regex:/(^([a-zA-z ]+)(\d+)?$)/u',
		   'item_name.*'=>'required|regex:/(^([a-zA-z ]+)(\d+)?$)/u',
		   'item_desc.*'=>'required|regex:/(^([a-zA-z ]+)(\d+)?$)/u',
		   'item_price.*'=>'required|numeric',
		   'item_qty.*'=>'required|numeric',
		   ],
		   [
		   'cust_name.required'=>'Please enter customer name',
		   'cust_phone.required'=>'Please enter customer phone',
		   'cust_email.required'=>'Please enter customer email',
		   'cust_address.required'=>'Please enter address'
		   ]
		   );
		    $id=$request->session()->get('inv_id');
			$objInvoices = Invoices::find($id);
			$objInvoices->cust_name = request('cust_name');
			$objInvoices->cust_phone = request('cust_phone');
			$objInvoices->cust_address = request('cust_address');
			$objInvoices->cust_email = request('cust_email');
			$objInvoices->inv_total = request('total_amount');
			$objInvoices->inv_discount = request('discount');
			$objInvoices->inv_vat = request('vat');
			$objInvoices->inv_grand_total = request('grand_total');
			if($objInvoices->save())
			{
				$objInvoicesdetilas = new Invoicedetails();
				$objInvoicesdetilas->where('invoice_id',$id)->delete();
				for($i=0;$i<count($_POST["item_name"]);$i++)
				{
					$objInvoicesdetilas = new Invoicedetails();
					$objInvoicesdetilas->invoice_id=$id;
					$objInvoicesdetilas->item_name=request('item_name')[$i];
					$objInvoicesdetilas->item_desc=request('item_desc')[$i];
					$objInvoicesdetilas->item_price=request('item_price')[$i];
					$objInvoicesdetilas->item_qty=request('item_qty')[$i];
					$objInvoicesdetilas->item_total=request('total')[$i];
					$objInvoicesdetilas->save();
				}
				return redirect('invoices');
			}
  }
   
  
}
