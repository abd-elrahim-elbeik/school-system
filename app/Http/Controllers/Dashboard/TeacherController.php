<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Models\Specialization;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Teachers = Teacher::all();
        return view('pages.Teachers.index', compact('Teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specializations = Specialization::all();
        $genders = Gender::all();
        return view('pages.Teachers.create', compact('specializations', 'genders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:teachers,email,',
            'password' => 'required',
            'name_ar' => 'required',
            'name_en' => 'required',
            'specialization_id' => 'required',
            'gender_id' => 'required',
            'joining_date' => 'required|date|date_format:Y-m-d',
            'address' => 'required',
        ]);

        $Teachers = new Teacher();
        $Teachers->email = $request->email;
        $Teachers->password =  Hash::make($request->password);
        $Teachers->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $Teachers->specialization_id = $request->specialization_id;
        $Teachers->gender_id = $request->gender_id;
        $Teachers->joining_date = $request->joining_date;
        $Teachers->address = $request->address;
        $Teachers->save();

        toastr()->success(trans('messages.success'));
        return redirect()->route('teachers.index');
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        $specializations = Specialization::all();
        $genders = Gender::all();
        return view('pages.Teachers.edit', compact('specializations', 'genders','teacher'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'email' => ['required',Rule::unique('teachers')->ignore($request->id)],
            'password' => 'required',
            'name_ar' => 'required',
            'name_en' => 'required',
            'specialization_id' => 'required',
            'gender_id' => 'required',
            'joining_date' => 'required|date|date_format:Y-m-d',
            'address' => 'required',
        ]);

        $Teachers = Teacher::findOrFail($request->id);
            $Teachers->email = $request->email;
            $Teachers->password =  Hash::make($request->password);
            $Teachers->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $Teachers->specialization_id = $request->specialization_id;
            $Teachers->gender_id = $request->gender_id;
            $Teachers->joining_date = $request->joining_date;
            $Teachers->address = $request->address;
            $Teachers->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('teachers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Teacher::findOrFail($request->id)->delete();

        toastr()->error(trans('messages.Delete'));
        return redirect()->route('teachers.index');
    }
}
