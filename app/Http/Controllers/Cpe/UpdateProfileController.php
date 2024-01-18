<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CoursesUser;
use App\Models\Course;
use App\Models\Meeting;
use App\Models\MeetingAttendant;
use App\Models\UserFavResource;
use Illuminate\Support\Facades\Hash;


class UpdateProfileController extends Controller
{
    public function index(Request $request){
        
        $updateUser = User::find(auth()->id());
        
        $updateUser->name = $request->input('name');
        
        $updateUser->documenttype_id = $request->input('documenttype_id');
        
        if(!$checkPhone = User::where('phone','57'.$request->input('phone'))){
            
            $updateUser->phone = '57'.$request->input('phone');
        }
        
        if($request->input('document')){
            
            $updateUser->document = $request->input('document');

        }
        
        $updateUser->place_role = $request->input('place_role');

        $updateUser->profile_id = $request->input('profile_id');
        
        $updateUser->department_id = $request->input('department_id');
        
        $updateUser->city_id = $request->input('city_id');
        
        if($request->input('password') != ''){
            
            $updateUser->password = Hash::make($request->input('password'));
            
        }
        
        $updateUser->save();

        $courses = CoursesUser::where('user_id',auth()->id())->orderBy('id','DESC')->get();

        $meetingsUser = Meeting::where('user_id',auth()->id())->orderBy('id','DESC')->get();

        $meetingAttendants =  MeetingAttendant::where('user_id',auth()->id())->orderBy('id','DESC')->get();

        $meetingsCount = Meeting::where('user_id',auth()->id())->orderBy('id','DESC')->get()->count();

        $attendantsCount = MeetingAttendant::where('user_id',auth()->id())->orderBy('id','DESC')->get()->count();

        $userApps = User::with(['media'])->where('id',auth()->id())->first();

        $userResources = UserFavResource::where('user_id',auth()->id())->get();
        
        $coordinatorCourses = Course::get();

        $today = date("Y-m-d");
        
        $message = '<h3>Perfil actualizado exitosamente</h3>';

        return view('cpe.mi-perfil',compact('courses','meetingsUser','meetingAttendants','userApps','meetingsCount','attendantsCount','today','userResources','message','coordinatorCourses'));
    }
}
