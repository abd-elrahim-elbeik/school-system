<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $class_rooms = Classroom::all();
        $grades = Grade::all();

        return view('pages.My_Classes.My_Classes',compact('class_rooms','grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $List_Classes = $request->List_Classes;

        $request->validate([
            'List_Classes.*.name_class' => 'required',
            'List_Classes.*.name_class_en' => 'required',
        ]);

        foreach ($List_Classes as $List_Class) {

            $My_Classes = new Classroom();

            $My_Classes->name_class = ['en' => $List_Class['name_class_en'], 'ar' => $List_Class['name_class']];

            $My_Classes->grade_id = $List_Class['grade_id'];

            $My_Classes->save();

        }

        toastr()->success(trans('messages.success'));
        return redirect()->route('classrooms.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'List_Classes.*.name_class' => 'required',
            'List_Classes.*.name_class_en' => 'required',
        ]);

        $Classrooms = Classroom::findOrFail($request->id);

        $Classrooms->update([

            $Classrooms->name_class = ['ar' => $request->name_class, 'en' => $request->name_class_en],
            $Classrooms->grade_id = $request->grade_id,
        ]);

        toastr()->success(trans('messages.Update'));
        return redirect()->route('classrooms.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Classroom::findOrFail($request->id)->delete();

        toastr()->success(trans('messages.Delete'));
        return redirect()->route('classrooms.index');
    }
    

    public function delete_all(Request $request)
    {
        $delete_all_id = explode(",", $request->delete_all_id);

        Classroom::whereIn('id', $delete_all_id)->Delete();
        toastr()->warning(trans('messages.Delete'));
        return redirect()->route('classrooms.index');
    }

    public function Filter_Classes(Request $request)
    {
        $grades = Grade::all();
        $Search = Classroom::select('*')->where('grade_id','=',$request->grade_id)->get();
        return view('pages.My_Classes.My_Classes',compact('grades'))->withDetails($Search);

    }
}
