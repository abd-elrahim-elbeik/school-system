<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrades;
use App\Models\Grade;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\BinaryOp\Greater;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::all();

        return view('pages.Grades.grades',compact('grades'));
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
    public function store(StoreGrades $request)
    {

        // if(Grade::where('name->ar',$request->name)->orWhere('name->en',$request->name_en)->exists()){
        //     return redirect()->back()->withErrors(trans('Grades_trans.exists'));
        // };

        // $request->validate([
        //     'name' => 'required'
        // ]);

        $validated = $request->validated();

        $grade = new Grade();

        $grade->name = ['en' => $request->name_en, 'ar' => $request->name];
        $grade->notes = $request->notes;
        $grade->save();


        toastr()->success(trans('messages.success'));
        return redirect()->route('grades.index');


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
    public function update(StoreGrades $request, Grade $grade)
    {
        // if(Grade::where('name->ar',$request->name)->orWhere('name->en',$request->name_en)->exists()){
        //     return redirect()->back()->withErrors(trans('Grades_trans.exists'));
        // };

        // $request->validate([
        //     'name' => 'required',
        // ]);

        $validated = $request->validated();

        $grade = Grade::findOrFail($request->id);

        $grade->update([
            $grade->name = ['en' => $request->name_en, 'ar' => $request->name],
            $grade->notes = $request->notes,
        ]);



        toastr()->success(trans('messages.Update'));
        return redirect()->route('grades.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Grade::findOrFail($request->id)->delete();

        toastr()->success(trans('messages.Delete'));
        return redirect()->route('grades.index');
    }
}
