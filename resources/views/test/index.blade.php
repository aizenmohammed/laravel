<html>
<head>
<title>INTERVIEW</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
</head>
<body >

<table cellpadding="2" cellspacing="0" width="25%" align="center">
<tr>
<td><input type="text" name="item" id="item"></td>
<td><button name="add" id="add" onclick="addtolist1()">Add</td>
<td></td>
<td></td>
<td><br><b>Selected item</td>
</tr>
</table>
<table cellpadding="2" cellspacing="0" width="25%" align="center" id="it">
<tr>
<td>
<select name="list1[]" id="list1" style="height:100px;width:175px;" multiple onclick="checkselection(1)">
@if(count($detailsright))
	@foreach($detailsright as $detailsright)
     <option value="{{$detailsright->id}}"> {{$detailsright->item_name}}</option>
    @endforeach
@endif	
</select>
</td>
<td><button name="right" id="right" onclick="moveright()">>

<p><button name="left" id="left" onclick="moverleft()"><</p>
</td>
<td>
<select name="list2" id="list2" style="height:100px;width:175px;" multiple onclick="checkselection(2)">
@if(count($detailsrleft))
	@foreach($detailsrleft as $detailsrleft)
     <option value="{{$detailsrleft->id}}"> {{$detailsrleft->item_name}}</option>
    @endforeach
@endif	
</select>
</td>
</tr>
</table>

</body>
<script type="text/javascript">
function addtolist1()
{
	if($("#item").val()=="" || $("#item").val()==null)
	{
	alert('The item must be not null');
	}
	else
	{
	var flag=checkDuplicate($("#item").val());	
	if(flag==1)
	{
	var sel = document.getElementById('list1');
	var opt = document.createElement('option');
	opt.appendChild( document.createTextNode($("#item").val()) );
	opt.value = $("#item").val(); 
	sel.appendChild(opt);
	$.ajaxSetup({
			headers: 	{
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
						});
						$.ajax({
			 type: 'POST',
			 url: "{{ url('/itemadd') }}",
			 data:{value:$("#item").val(),_token: "{{ csrf_token() }}","_method": 'POST'},
			 success: function (response) 
			 {
				if(response==1)
				 {
					 
					$("#it").load(" #it");
				 } 
				 
			 }
			 });
	}
	else
	{
		alert('the item allready exists in list');
	}
	$("#item").val('');
	$( "#item").focus();
	
	}
}
function checkDuplicate(item)
{
	var count = $('#list1 > option').length;
	var element =$('#list1 > option');
	var flag=1;
	for(i=0;i<count;i++)
	{
		if(element[i].text==item)
		{
			flag=0;
			break;
		}
		
		
	
	}
	if(flag==1)
	{
	var count = $('#list2 > option').length;
	var element =$('#list2 > option');
	var flag=1;
	for(i=0;i<count;i++)
	{
		if(element[i].text==item)
		{
			flag=0;
			break;
		}
		
		
	
	}
	}
	return flag;
}
function moveright()
{
	var count = $('#list1 > option').length;
	var element =$('#list1 > option');
	var flag=1;
	var sel = document.getElementById('list2');
	for(i=0;i<count;i++)
	{
		if(element[i].selected)
		{
	var opt = document.createElement('option');
	opt.appendChild( document.createTextNode(element[i].text));
	opt.value = element[i].value; 
	sel.appendChild(opt);
	element[i].remove();
	var position=2;
	callajax(element[i].value,position);
		}
		
	
	}
}
function checkselection(id)
{
	var count = $('#list'+id+' > option').length;
	var element =$('#list'+id+' > option');
	var flag=0;
	for(i=0;i<count;i++)
	{
		if(element[i].selected)
		{
			flag++;
		}
	}
	
	if(flag>1)
	{
		alert('Only one item allow for one time');
		element.prop('selected',false);
		return false;
	}
}
function moverleft()
{
	var count = $('#list2 > option').length;
	var element =$('#list2 > option');
	var flag=1;
	var sel = document.getElementById('list1');
	for(i=0;i<count;i++)
	{
		if(element[i].selected)
		{
	var opt = document.createElement('option');
	opt.appendChild( document.createTextNode(element[i].text));
	opt.value = element[i].value; 
	sel.appendChild(opt);
	element[i].remove();
	var position=1;
	callajax(element[i].value,position);
		}
		
	
	}
}
function callajax(item,position)
{
	$.ajaxSetup({
			headers: 	{
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
						});
						$.ajax({
			 type: 'POST',
			 url: "{{ url('/changeposition') }}",
			 data:{item:item,position:position,_token: "{{ csrf_token() }}","_method": 'POST'},
			 success: function (response) 
			 {
				if(response==1)
				 {
					 
					$("#it").load(" #it");
				 } 
				 
			 }
			 });
}
</script>
</html>