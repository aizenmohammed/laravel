<?php 
use \App\Http\Controllers\invoicesController;
?>
<html>
<head>
<title>EDIT INVOICE</title>
<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
</head>
<body>
@if(count($errors)>0)
									@foreach($errors->all() as $error)
									<div class="alert alert-mini alert-danger margin-bottom-30">
									{{$error}}
									</div>
									@endforeach
									@endif
<form action="{{URL::to('inv_edit')}}" method="POST">
      <table cellpadding="2" cellspacing="0" width="50%" align="center">
	  <tr>
	  <td>Customer Name:</td><td><input type="text" name="cust_name" value="{{$invoiceArr->cust_name}}"></td>
	  <td>Customer phone:</td><td><input type="number" name="cust_phone" value="{{$invoiceArr->cust_phone}}"></td>
	  </tr>
	  <tr>
	  <td>Customer address:</td><td><input type="text" name="cust_address" value="{{$invoiceArr->cust_address}}"></td>
	  <td>Customer Email:</td><td><input type="email" name="cust_email" value="{{$invoiceArr->cust_email}}"></td>
	  </tr>
	  </table>
	  <p>
	  <table cellpadding="2" cellspacing="0" width="50%" align="center">
	  <tr>
	  <td>Item name</td>
	  <td>Item description</td>
	  <td>Item price</td>
	  <td>Item qty</td>
	  <td>Total</td>
	  </tr>
	  </table>
	  <table cellpadding="2" cellspacing="0" width="50%" align="center" class="item" id="item">
	  <tbody>
	  <?php
	  $invoicedetails = invoicesController::getInvoicedetails($invoiceArr->id);
	  $i=1;
	  ?>
	  @foreach($invoicedetails as $invoicedetails)
	  <tr class="itemm_<?php echo $i;?>">
	  <td><input type="text" name="item_name[]" id="item_name_<?php echo time();?>" value="{{$invoicedetails->item_name}}"></td>
	  <td><input type="text" name="item_desc[]" id="item_desc_<?php echo time();?>" value="{{$invoicedetails->item_desc}}"></td>
	  <td ><input type="number" name="item_price[]" id="item_price_<?php echo time();?>" onChange="calculate(<?php echo time();?>)" value="{{$invoicedetails->item_price}}"></td>
	  <td><input type="number" name="item_qty[]" id="item_qty_<?php echo time();?>" onChange="calculate(<?php echo time();?>)" value="{{$invoicedetails->item_qty}}"></td>
	  <td><input type="text" name="total[]" id="total_<?php echo time();?>" readonly value="{{$invoicedetails->item_total}}"></td>
	  
	  <td><button type="button"  onclick="delitem(<?php echo $i;?>);">-</td>
	  <?php $i++;?>
	  </tr>
	  @endforeach
	  </tbody>
	  </table>
	  
	  <table cellpadding="5" cellspacing="0" width="50%" align="center">
	  <tr>
	  <td>Total:</td><td><input type="text" name="total_amount" id="total_amount" value="{{$invoiceArr->inv_total}}" readonly></td>
	  <td>Discount 15%:</td><td><input type="text" name="discount" id="discount" value="{{$invoiceArr->inv_discount}}"value="0" readonly></td>
	  </tr>
	  <tr>
	  <td>Vat 5 %:</td><td><input type="text" name="vat" id="vat" value="{{$invoiceArr->inv_vat}}" readonly></td>
	  <td>Grand Total:</td><td><input type="text" name="grand_total" id="grand_total" value="{{$invoiceArr->inv_grand_total}}" readonly></td>
	  </tr>
	  <tr>
	  </tr>
	  <tr>
	  <td></td>
	  <td><input type="submit" name="add" value="Update  Invoice"></td>
	  </tr>
	  </table>
	  
	  <input type="hidden" name="_token" value="{{csrf_token()}}">
    </form>
	</div>
	</div>
</body>
<script type="text/javascript">
function additem()
{
var time = Date.now();	
$('.item tbody').append('<tr class="itemm_'+time+'"><td><input type="text" name="item_name[]" id="item_name_'+time+'"></td><td><input type="text" name="item_desc[]" id="item_name_'+time+'"></td> <td><input type="number" name="item_price[]" id="item_price_'+time+'" onChange="calculate('+time+')"></td><td><input type="number" name="item_qty[]" id="item_qty_'+time+'" onChange="calculate('+time+')"></td> <td><input type="text" name="total[]" id="total_'+time+'" readonly></td><td><button type="button" onclick="delitem('+time+')">-</button></td></tr>');
}
function delitem(id){
			$('.itemm_'+id).remove();
			calcTotal();
}
function calculate(id)
{
	var qty=$("#item_qty_"+id).val();
	var price=$("#item_price_"+id).val();
	var total=eval(qty*price);
	$("#total_"+id).val(total);
	calcTotal();
}
function calcTotal()
{
	var tab = $('.item tr');
	var total=0;
for (var i = 0; i < tab.length; i++) {
    var price = $(tab[i].cells[2].children[0]).val();
    var qty = $(tab[i].cells[3].children[0]).val();
	
	total+=eval(qty*price); 
	
}
	var discount=eval(total*15)/100;
	var tot=eval(total-discount)
	var vat =eval(tot*5)/100;
	var gtotal = eval(tot+vat)
	$("#total_amount").val(total);
	$("#discount").val(discount);
	$("#vat").val(vat);
	$("#grand_total").val(gtotal);
}
</script>
</html>