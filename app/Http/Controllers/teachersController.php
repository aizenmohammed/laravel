<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Teachers;
use App\Qualifications;
use App\Classes;
use App\Attendances;
use DB;
class teachersController extends Controller
{
	public function index(Request $request)
	{
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
		
		$teachersT=DB::table('teachers')
            ->join('qualifications', 'teachers.qualification_id', '=', 'qualifications.id')
			->where('teachers.status',1)
           ->select('teachers.*','qualifications.degree')
            ->get();
			$teachers=DB::table('teachers')
            ->join('qualifications', 'teachers.qualification_id', '=', 'qualifications.id')
			->where('teachers.status',1)
           ->select('teachers.*','qualifications.degree')
            ->offset($start)->take($noofitems)->get()->sortBy('id');
		return view('teachers.index',compact('teachers','pagesize','teachersT','noofitems'));
	}
	public function addTeacher(Request $request)
	{
		if(count($_POST)>0)
		{
			
			if($request->id==0)
			{
			$this->validate(request(),[
		   'first_name'=>'required|regex:/(^([a-zA-z]+)(\d+)?$)/u',
		   'last_name'=>'required|regex:/(^([a-zA-z]+)(\d+)?$)/u',
		   'email_address'=>'required|email|unique:teachers,email,NULL,id,status,1',
		   'phone_number'=>'required|numeric',
		   'qualifications'=>'required',
		   'present_address'=>'required'
		   ],
		   [
		   'last_name.required'=>'Please enter firstname',
		   'last_name.required'=>'Please enter lastname',
		   'email_address.required'=>'Please enter email',
		   'phone_number.required'=>'Please enter phone',
		   'qualifications.required'=>'Please select qualification',
		   'present_address.required'=>'Please enter address',
		   ]
		   );
		   
		   $objTeachers =  new Teachers();
		   $objTeachers->firstname = strip_tags(request('first_name'));
		   $objTeachers->lastname = strip_tags(request('last_name'));
		   $objTeachers->email = strip_tags(request('email_address'));
		   $objTeachers->phone = strip_tags(request('phone_number'));
		   $objTeachers->qualification_id = strip_tags(request('qualifications'));
		   $objTeachers->address = strip_tags(request('present_address'));
		   $objTeachers->assgined_classes=implode(",",$request->classes);
		   if($objTeachers->save())
		   {
			   
			   $request->session()->flash('REG-MSG','Employee details added successfully');
			   return redirect('teachers');
		   }
			}
		else
		{
			$this->validate(request(),[
		   'first_name'=>'required|regex:/(^([a-zA-z]+)(\d+)?$)/u',
		   'last_name'=>'required|regex:/(^([a-zA-z]+)(\d+)?$)/u',
		   'email_address'=>'required|email',
		   'phone_number'=>'required|numeric',
		   'qualifications'=>'required',
		   'present_address'=>'required'
		   ],
		   [
		   'last_name.required'=>'Please enter firstname',
		   'last_name.required'=>'Please enter lastname',
		   'email_address.required'=>'Please enter email',
		   'phone_number.required'=>'Please enter phone',
		   'qualifications.required'=>'Please select qualification',
		   'present_address.required'=>'Please enter address',
		   ]
		   );
		   
		   $objTeachers =  Teachers::find($request->id);
		   $objTeachers->firstname = strip_tags(request('first_name'));
		   $objTeachers->lastname = strip_tags(request('last_name'));
		   $objTeachers->email = strip_tags(request('email_address'));
		   $objTeachers->phone = strip_tags(request('phone_number'));
		   $objTeachers->qualification_id = strip_tags(request('qualifications'));
		   $objTeachers->address = strip_tags(request('present_address'));
		   $objTeachers->assgined_classes=implode(",",$request->classes);
		   if($objTeachers->save())
		   {
			   $request->session()->flash('REG-MSG','Employee details added successfully');
			   return redirect('teachers');
		   }
		}
		}
		else
		{
	    $details=array();
		if(isset($request->id))
		{
			$id=preg_replace('/[^0-9\-]/', '',strip_tags($request->id));
			$details=Teachers::find($id);
		}
		
		$qualifications = Qualifications::all();
		$classes = Classes::all();
		return view('teachers.add',compact('qualifications','details','classes'));
		}
	}
	public function show(Request $request)
	{
		$id=preg_replace('/[^0-9\-]/', '',strip_tags($request->id));
		$details=DB::table('teachers')
            ->join('qualifications', 'teachers.qualification_id', '=', 'qualifications.id')
			->where([['teachers.id',$id],['teachers.status',1]])
           ->select('teachers.*','qualifications.degree')
            ->first();
		return view('teachers.details',compact('details'));
	}
	
	public function deleteitem(Request $request)
	{
		$id=$request->id;
		$details=Teachers::find($id);
		$details->status=0;
		$status=0;
		if($details->save())
		{
			$status=1;
		}
		return $status;
	}
	public function makeattendance(Request $request)
	{
		$id=$request->id;
		$date=date('Y-m-d');
		$status=$request->status;
		$objAttendance= new Attendances();
		$count=$objAttendance->where([['teacher_id',$id],['date_attendance',$date]])->count();
		if($count==0)
		{

			$objAttendance->teacher_id=$id;
			$objAttendance->date_attendance=$date;
			$objAttendance->status=$status;
			
		}
		else
		{
			$arr=$objAttendance->where([['teacher_id',$id],['date_attendance',$date]])->first();
			$objAttendance = Attendances::find($arr->id);
			$objAttendance->status=$status;
			
		}
		if($objAttendance->save())
			{
				$final=1;
			}
		
			return $final;
		
	}
	public static function getStatus($id)
	{
		$objAttendance= new Attendances();
		$date=date('Y-m-d');
		$arr=$objAttendance->where([['teacher_id',$id],['date_attendance',$date]])->first();
		if(isset($arr->status))
			return $arr->status;
		else
			return 3;
		
	}
}
?>