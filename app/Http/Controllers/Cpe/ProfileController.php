<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CoursesUser;
use App\Models\Course;
use App\Models\Meeting;
use App\Models\MeetingAttendant;
use App\Models\UserFavResource;

class ProfileController extends Controller
{
    public function index()
    {
            
			$courses = CoursesUser::where('user_id',auth()->id())->orderBy('id','DESC')->get();

			$meetingsUser = Meeting::where('user_id',auth()->id())->orderBy('id','DESC')->get();

			$meetingAttendants =  MeetingAttendant::where('user_id',auth()->id())->orderBy('id','DESC')->get();
						
			$meetingsCount = Meeting::where('user_id',auth()->id())->orderBy('id','DESC')->get()->count();
			
			$attendantsCount = MeetingAttendant::where('user_id',auth()->id())->orderBy('id','DESC')->get()->count();

			$userApps = User::with(['media'])->where('id',auth()->id())->first();
            
            $userResources = UserFavResource::where('user_id',auth()->id())->get();
            
            $coordinatorCourses = Course::get();
            			
			$today = date("Y-m-d");

			return view('cpe.mi-perfil', compact('courses','meetingsUser','meetingAttendants','userApps','meetingsCount','attendantsCount','today','userResources','coordinatorCourses'));
		
    }
}
