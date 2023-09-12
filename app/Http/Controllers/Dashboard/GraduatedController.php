<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class GraduatedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::onlyTrashed()->get();;

        return view('pages.Students.Graduated.index',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Grades = Grade::all();
        return view('pages.Students.Graduated.create',compact('Grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $students = student::where('Grade_id',$request->Grade_id)->where('Classroom_id',$request->Classroom_id)->where('section_id',$request->section_id)->get();

        if($students->count() < 1){
            return redirect()->back()->with('error_Graduated', __('لاتوجد بيانات في جدول الطلاب'));
        }

        foreach ($students as $student){
            $ids = explode(',',$student->id);
            student::whereIn('id', $ids)->Delete();
        }

        toastr()->success(trans('messages.success'));
        return redirect()->route('graduated.index');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) //to restore student from softdelete
    {
        student::onlyTrashed()->where('id', $request->id)->first()->restore();

        toastr()->success(trans('messages.success'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request) //to delete student from softdelete
    {
        student::onlyTrashed()->where('id', $request->id)->first()->forceDelete();

        toastr()->error(trans('messages.Delete'));
        return redirect()->back();
    }
}
