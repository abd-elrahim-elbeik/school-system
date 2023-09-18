<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Quizze;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class QuizzeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quizze::all();
        return view('pages.Quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grades = Grade::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();

        return view('pages.Quizzes.create',compact('grades','subjects','teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'Name_en' => 'required',
            'Name_ar' => 'required',
            'subject_id' => 'required',
            'Grade_id' => 'required',
            'Classroom_id' => 'required',
            'section_id' => 'required',
            'teacher_id' => 'required',
        ]);


        try {

            $quizzes = new Quizze();
            $quizzes->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $quizzes->subject_id = $request->subject_id;
            $quizzes->grade_id = $request->Grade_id;
            $quizzes->classroom_id = $request->Classroom_id;
            $quizzes->section_id = $request->section_id;
            $quizzes->teacher_id = $request->teacher_id;
            $quizzes->save();

            toastr()->success(trans('messages.success'));

            return redirect()->route('quizzes.index');
        }
        catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quizz = Quizze::findorFail($id);

        $grades = Grade::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();

        return view('pages.Quizzes.edit', compact('quizz','grades','subjects','teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $request->validate([
            'Name_en' => 'required',
            'Name_ar' => 'required',
            'subject_id' => 'required',
            'Grade_id' => 'required',
            'Classroom_id' => 'required',
            'section_id' => 'required',
            'teacher_id' => 'required',
        ]);

        
        try {
            $quizz = Quizze::findorFail($request->id);
            $quizz->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $quizz->subject_id = $request->subject_id;
            $quizz->grade_id = $request->Grade_id;
            $quizz->classroom_id = $request->Classroom_id;
            $quizz->section_id = $request->section_id;
            $quizz->teacher_id = $request->teacher_id;
            $quizz->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Quizzes.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            Quizze::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
