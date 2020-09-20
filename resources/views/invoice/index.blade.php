<html>
<head>
<title>Invoice List</title>
</head>
<body>
<a href="{{URL::to('inv_add')}}">New Invoice</a>
<table cellpadding="5" cellspacing="0" width="50%" align="center">
<tr>
<td>Sl.no </td>
<td>Invoice ID </td>
<td>Customer name</td>
<td>Phone</td>
<td>Total</td>
<td></td>
<td></td>
</tr>
<?php $i=1;?>
@foreach($invoiceArr as $invoiceArr)
<tr>
<td><?php echo $i;?></td>
<td>INVOICE-NO<?php echo $invoiceArr->id;?></td>
<td><?php echo $invoiceArr->cust_name;?></td>
<td><?php echo $invoiceArr->cust_phone;?></td>
<td><?php echo round($invoiceArr->inv_grand_total,2);?></td>
<td><a href="{{URL::to('inv_details/'.$invoiceArr->id)}}">Show details</a></td>
<td><a href="{{URL::to('inv_edit/'.$invoiceArr->id)}}">Edit</a></td>
</tr>
<?php $i++;?>
@endforeach
</table>
<?php $value=(count($invoiceArrT))/$noofitems;?>
						<!-- Pagination Default -->
						@if($value>1)
							<?php if(count($invoiceArrT)>$noofitems){ $value+=1;}?>
						<ul class="pagination">
							<li><a href="#">&laquo;</a></li>
							
								<?php for($i=1;$i<$value;$i++){?>
							<?php if($pagesize==$i) { $class="active"; } else { $class=""; }?>
							<li class="<?php echo $class; ?>"><a href="{{URL::to('invoices/'.$i)}}">{{$i}}</a></li>
								<?php }?>
							
							<li><a href="#">&raquo;</a></li>
						</ul>
						@endif
</body>
</html>