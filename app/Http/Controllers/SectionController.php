<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::with('sections','classrooms')->get();
        //$grades_class = Grade::with('classrooms')->get();
        $classes = Classroom::all();

        return view('pages.Sections.Sections',compact('grades','classes'));
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
        $request->validate([
            'name_section' => 'required',
            'name_section_en' => 'required',

        ]);

      $sections = new Section();

      $sections->name_section = ['ar' => $request->name_section , 'en' => $request->name_section_en];
      $sections->grade_id = $request->Grade_id;
      $sections->classroom_id = $request->Class_id;
      $sections->status = 1;
      $sections->save();

      //$Sections->teachers()->attach($request->teacher_id);

      toastr()->success(trans('messages.success'));
      return redirect()->route('sections.index');
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
    public function update(Request $request)
    {
        $request->validate([
            'name_section' => 'required',
            'name_section_en' => 'required',

        ]);

        $sections = Section::findOrFail($request->id);

        if(isset($request->Status)) {
            $sa = 1;
          } else {
            $sa = 2;
          }

          //dd($request);

        $sections->update([
            $sections->name_section = ['ar' => $request->name_section , 'en' => $request->name_section_en],
            $sections->grade_id = $request->Grade_id,
            $sections->classroom_id = $request->Class_id,
            $sections->status = $sa,


        ]);

        toastr()->success(trans('messages.Update'));
        return redirect()->route('sections.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Section::findOrFail($request->id)->delete();

        toastr()->success(trans('messages.Delete'));
        return redirect()->route('sections.index');
    }

    public function getclasses($id)
    {
        $list_classes = Classroom::where("grade_id", $id)->pluck("name_class", "id");

        return $list_classes;
    }
}
