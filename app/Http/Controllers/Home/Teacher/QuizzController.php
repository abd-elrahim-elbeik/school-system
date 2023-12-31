<?php

namespace App\Http\Controllers\Home\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Models\Grade;
use App\Models\Question;
use App\Models\Quizze;
use App\Models\Subject;
use Illuminate\Http\Request;

class QuizzController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quizze::where('teacher_id',auth()->user()->id)->get();

        return view('pages.Teachers.dashboard.Quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['grades'] = Grade::all();
        $data['subjects'] = Subject::where('teacher_id',auth()->user()->id)->get();

        return view('pages.Teachers.dashboard.Quizzes.create', $data);

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
        ]);

        try {
            $quizzes = new Quizze();
            $quizzes->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $quizzes->subject_id = $request->subject_id;
            $quizzes->grade_id = $request->Grade_id;
            $quizzes->classroom_id = $request->Classroom_id;
            $quizzes->section_id = $request->section_id;
            $quizzes->teacher_id = auth()->user()->id;
            $quizzes->save();

            toastr()->success(trans('messages.success'));
            return redirect()->route('quizzes.index');

        }
        catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $questions = Question::where('quizze_id',$id)->get();
        $quizz = Quizze::findorFail($id);
        return view('pages.Teachers.dashboard.Questions.index',compact('questions','quizz'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quizz = Quizze::findorFail($id);
        $data['grades'] = Grade::all();
        $data['subjects'] = Subject::where('teacher_id',auth()->user()->id)->get();
        return view('pages.Teachers.dashboard.Quizzes.edit', $data, compact('quizz'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'Name_en' => 'required',
            'Name_ar' => 'required',
            'subject_id' => 'required',
            'Grade_id' => 'required',
            'Classroom_id' => 'required',
            'section_id' => 'required',
        ]);


        try {
            $quizz = Quizze::findorFail($request->id);
            $quizz->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $quizz->subject_id = $request->subject_id;
            $quizz->grade_id = $request->Grade_id;
            $quizz->classroom_id = $request->Classroom_id;
            $quizz->section_id = $request->section_id;
            $quizz->teacher_id = auth()->user()->id;
            $quizz->save();

            toastr()->success(trans('messages.Update'));
            return redirect()->route('quizzes.index');

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Quizze::destroy($id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function student_quizze($quizze_id)
    {
        $degrees = Degree::where('quizze_id', $quizze_id)->get();
        
        return view('pages.Teachers.dashboard.Quizzes.student_quizze', compact('degrees'));
    }

    public function repeat_quizze(Request $request)
    {
        Degree::where('student_id', $request->student_id)->where('quizze_id', $request->quizze_id)->delete();
        toastr()->success('تم فتح الاختبار مرة اخرى للطالب');
        return redirect()->back();
    }
}
