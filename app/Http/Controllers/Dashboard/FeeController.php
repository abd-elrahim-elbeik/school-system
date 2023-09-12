<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Grade;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fees = Fee::all();

        return view('pages.Fees.index', compact('fees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Grades = Grade::all();

        return view('pages.Fees.create', compact('Grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required',
            'title_en' => 'required',
            'amount' => 'required|numeric',
            'Grade_id' => 'required|integer',
            'Classroom_id' => 'required|integer',
            'year' => 'required',
        ]);

        $fees = new Fee();

        $fees->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
        $fees->amount  = $request->amount;
        $fees->grade_id  = $request->Grade_id;
        $fees->classroom_id  = $request->Classroom_id;
        $fees->description  = $request->description;
        $fees->year  = $request->year;
        $fees->fee_type  = $request->Fee_type;

        $fees->save();

        toastr()->success(trans('messages.success'));
        return redirect()->route('fees.index');
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fee = Fee::findorfail($id);
        $Grades = Grade::all();

        return view('pages.Fees.edit', compact('fee','Grades'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $request->validate([
            'title_ar' => 'required',
            'title_en' => 'required',
            'amount' => 'required|numeric',
            'Grade_id' => 'required|integer',
            'Classroom_id' => 'required|integer',
            'year' => 'required',
        ]);

        $fees = Fee::findorfail($request->id);

        $fees->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
        $fees->amount  =$request->amount;
        $fees->grade_id  =$request->Grade_id;
        $fees->classroom_id  =$request->Classroom_id;
        $fees->description  =$request->description;
        $fees->year  =$request->year;
        $fees->fee_type  =$request->Fee_type;

        $fees->save();

        toastr()->success(trans('messages.Update'));
        return redirect()->route('fees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Fee::destroy($request->id);

        toastr()->error(trans('messages.Delete'));
        return redirect()->route('fees.index');
    }
}
