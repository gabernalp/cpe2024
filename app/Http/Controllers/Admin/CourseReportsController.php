<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEducationalBgReportRequest;
use App\Http\Requests\StoreEducationalBgReportRequest;
use App\Http\Requests\UpdateEducationalBgReportRequest;
use App\Models\CourseSchedule;
use App\Models\CoursesUser;
use App\Models\Challenge;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseReportsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('educational_bg_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        abort_if(!CourseSchedule::find(($_GET['id'])), Response::HTTP_FORBIDDEN, '403 Forbidden');
                
        $courseUsers = CoursesUser::where('course_schedule_id',$_GET['id'])->get();
                
        $courseSchedule = CourseSchedule::find($_GET['id']);
        
        $courseChallenges = Challenge::where('course_id',$courseSchedule->course_id)->get();
        
        return view('admin.educationalBgReports.report', compact('courseUsers','courseSchedule','courseChallenges'));
    }


}
