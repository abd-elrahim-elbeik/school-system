<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Grades = Grade::all();
        $teachers = Teacher::all();
        return view('pages.Attendance.index',compact('Grades','teachers'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            foreach ($request->attendences as $studentid => $attendence) {

                if( $attendence == 'presence' ) {
                    $attendence_status = true;
                } else if( $attendence == 'absent' ){
                    $attendence_status = false;
                }

                Attendance::create([
                    'student_id'=> $studentid,
                    'grade_id'=> $request->grade_id,
                    'classroom_id'=> $request->classroom_id,
                    'section_id'=> $request->section_id,
                    'teacher_id'=> 1,
                    'attendence_date'=> date('Y-m-d'),
                    'attendence_status'=> $attendence_status
                ]);

            }

            toastr()->success(trans('messages.success'));
            return redirect()->back();

        }

        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $students = Student::with('attendance')->where('section_id',$id)->get();
        return view('pages.Attendance.create',compact('students'));
    }


}
