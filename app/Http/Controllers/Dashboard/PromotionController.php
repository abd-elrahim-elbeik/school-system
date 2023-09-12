<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Promotion;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = promotion::all();
        return view('pages.Students.promotion.index',compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Grades = Grade::all();
        return view('pages.Students.promotion.create',compact('Grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $students = Student::where('grade_id',$request->Grade_id)->where('classroom_id',$request->Classroom_id)->where('section_id',$request->section_id)->where('academic_year',$request->academic_year)->get();

            if($students->count() < 1){
                return redirect()->back()->with('error_promotions', __('لاتوجد بيانات في جدول الطلاب'));
            }

            // update in table student
            foreach ($students as $student){

                $ids = explode(',',$student->id);
                student::whereIn('id', $ids)
                    ->update([
                        'grade_id'=>$request->Grade_id_new,
                        'classroom_id'=>$request->Classroom_id_new,
                        'section_id'=>$request->section_id_new,
                        'academic_year'=>$request->academic_year_new,
                    ]);


                // insert in to promotions
                Promotion::updateOrCreate([
                    'student_id'=>$student->id,
                    'from_grade'=>$request->Grade_id,
                    'from_classroom'=>$request->Classroom_id,
                    'from_section'=>$request->section_id,
                    'to_grade'=>$request->Grade_id_new,
                    'to_classroom'=>$request->Classroom_id_new,
                    'to_section'=>$request->section_id_new,
                    'academic_year'=>$request->academic_year,
                    'academic_year_new'=>$request->academic_year_new,
                ]);

            }
            DB::commit();
            toastr()->success(trans('messages.success'));
            return redirect()->route('promotion.index');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {

            //delete all
            if($request->page_id ==1){

             $Promotions = Promotion::all();
             foreach ($Promotions as $Promotion){

                 $ids = explode(',',$Promotion->student_id);
                 student::whereIn('id', $ids)
                 ->update([
                 'grade_id'=>$Promotion->from_grade,
                 'classroom_id'=>$Promotion->from_classroom,
                 'section_id'=> $Promotion->from_section,
                 'academic_year'=>$Promotion->academic_year,
               ]);

                //delete table
                Promotion::truncate();

             }
                // DB::commit();
                toastr()->error(trans('messages.Delete'));
                return redirect()->route('promotion.index');

            }

            else{

                $Promotion = Promotion::findorfail($request->id);
                student::where('id', $Promotion->student_id)
                    ->update([
                        'grade_id'=>$Promotion->from_grade,
                        'classroom_id'=>$Promotion->from_classroom,
                        'section_id'=> $Promotion->from_section,
                        'academic_year'=>$Promotion->academic_year,
                    ]);


                Promotion::destroy($request->id);
                // DB::commit();
                toastr()->error(trans('messages.Delete'));
                return redirect()->route('promotion.index');

            }

        }

        catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
