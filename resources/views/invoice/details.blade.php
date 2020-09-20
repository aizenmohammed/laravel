<?php 
use \App\Http\Controllers\invoicesController;
?>
<html>
<head>
<title>DETAILS</title>
</head>
<body>
<table cellpadding="2" cellspacing="0" width="50%" align="center">
	  <tr>
	  <td>Customer Name:</td><td><b>{{$invoiceArr->cust_name}}</b></td>
	  <td>Customer phone:</td><td><b>{{$invoiceArr->cust_phone}}</b></td>
	  </tr>
	  <tr>
	  <td>Customer address:</td><td><b>{{$invoiceArr->cust_address}}</b></td>
	  <td>Customer Email:</td><td><b>{{$invoiceArr->cust_email}}</b></td>
	  </tr>
	  </table>
	  <p>
	  <?php $invoicedetails = invoicesController::getInvoicedetails($invoiceArr->id);?>
	  <table cellpadding="2" cellspacing="0" width="50%" align="center">
	  <tr>
	  <td><b>Item name</b></td>
	  <td><b>Item description</b></td>
	  <td><b>Item price</b></td>
	  <td><b>Item qty</b></td>
	  <td><b>Total</b></td>
	  </tr>
	  </table>
	  <table cellpadding="2" cellspacing="0" width="50%" align="center" >
	  @foreach($invoicedetails as $invoicedetails)
	  <tr>
	  <td>{{$invoicedetails->item_name}}</td>
	  <td>{{$invoicedetails->item_desc}}</td>
	  <td>{{$invoicedetails->item_price}}</td>
	  <td>{{$invoicedetails->item_qty}}</td>
	  <td>{{$invoicedetails->item_total}}</td>
	  </tr>
	  @endforeach
	  </table>
	  <p>
	   <table cellpadding="5" cellspacing="0" width="50%" align="center">
	  <tr>
	  <td>Total:</td><td><b>{{$invoiceArr->inv_total}}</b></td>
	  <td>Discount 15%:</td><td><b><?php echo round($invoiceArr->inv_discount,2);?></b></td>
	  </tr>
	  <tr>
	  <td>Vat 5 %:</td><td><b><?php echo round($invoiceArr->inv_vat,2);?></b></td>
	  <td>Grand Total:</td><td><b><?php echo round($invoiceArr->inv_grand_total,2);?></b></td>
	  </tr>
	  <tr>
	  </tr>
	  <tr>
	  <td></td>
	  <td><a href="{{URL::to('invoices')}}">Back</a></td>
	  </tr>
	  </table>
	  </body>
	  </html>
	  