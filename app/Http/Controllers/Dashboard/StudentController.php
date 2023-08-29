<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\Image;
use App\Models\MyParent;
use App\Models\Nationality;
use App\Models\Section;
use App\Models\Student;
use App\Models\TypeBlood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return view('pages.Students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genders = Gender::all();
        $parents = MyParent::all();
        $nationalitys = Nationality::all();
        $type_bloods = TypeBlood::all();
        $grades = Grade::all();

        return view('pages.Students.add', compact('genders', 'parents', 'nationalitys', 'type_bloods', 'grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:6|max:10',
            'gender_id' => 'required',
            'nationalitie_id' => 'required',
            'blood_id' => 'required',
            'Date_Birth' => 'required|date|date_format:Y-m-d',
            'Grade_id' => 'required',
            'Classroom_id' => 'required',
            'section_id' => 'required',
            'parent_id' => 'required',
            'academic_year' => 'required',
        ]);
        // DB::beginTransaction();

        // try {
        $students = new Student();
        $students->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $students->email = $request->email;
        $students->password = Hash::make($request->password);
        $students->gender_id = $request->gender_id;
        $students->nationalitie_id = $request->nationalitie_id;
        $students->blood_id = $request->blood_id;
        $students->date_birth = $request->Date_Birth;
        $students->Grade_id = $request->Grade_id;
        $students->Classroom_id = $request->Classroom_id;
        $students->section_id = $request->section_id;
        $students->parent_id = $request->parent_id;
        $students->academic_year = $request->academic_year;
        $students->save();

        // insert img
        // if($request->hasfile('photos'))
        // {
        //     foreach($request->file('photos') as $file)
        //     {
        //         $name = $file->getClientOriginalName();
        //         $file->storeAs('attachments/students/'.$students->name, $file->getClientOriginalName(),'upload_attachments');

        //         // insert in image_table
        //         $images= new Image();
        //         $images->filename=$name;
        //         $images->imageable_id= $students->id;
        //         $images->imageable_type = 'App\Models\Student';
        //         $images->save();
        //     }
        // }
        // DB::commit(); // insert data
        toastr()->success(trans('messages.success'));
        return redirect()->route('students.index');

        // }

        // catch (\Exception $e){
        //     DB::rollback();
        //     return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Student = Student::findorfail($id);
        $nationalities = Nationality::all();
        $parents = MyParent::all();
        return view('pages.Students.show', compact('Student','nationalities','parents'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $genders = Gender::all();
        $parents = MyParent::all();
        $nationalitys = Nationality::all();
        $type_bloods = TypeBlood::all();
        $grades = Grade::all();

        return view('pages.Students.edit', compact('genders', 'parents', 'nationalitys', 'type_bloods', 'grades', 'student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'email' => ['required',Rule::unique('teachers')->ignore($request->id)],
            'password' => 'required|string',
            'gender_id' => 'required',
            'nationalitie_id' => 'required',
            'blood_id' => 'required',
            'Date_Birth' => 'required|date|date_format:Y-m-d',
            'Grade_id' => 'required',
            'Classroom_id' => 'required',
            'section_id' => 'required',
            'parent_id' => 'required',
            'academic_year' => 'required',
        ]);

        $Edit_Students = Student::findorfail($request->id);
        $Edit_Students->name = ['ar' => $request->name_ar, 'en' => $request->name_en];
        $Edit_Students->email = $request->email;
        $Edit_Students->password = Hash::make($request->password);
        $Edit_Students->gender_id = $request->gender_id;
        $Edit_Students->nationalitie_id = $request->nationalitie_id;
        $Edit_Students->blood_id = $request->blood_id;
        $Edit_Students->Date_Birth = $request->Date_Birth;
        $Edit_Students->Grade_id = $request->Grade_id;
        $Edit_Students->Classroom_id = $request->Classroom_id;
        $Edit_Students->section_id = $request->section_id;
        $Edit_Students->parent_id = $request->parent_id;
        $Edit_Students->academic_year = $request->academic_year;
        $Edit_Students->save();


        toastr()->success(trans('messages.Update'));
        return redirect()->route('students.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Student::findOrFail($request->id)->delete();

        toastr()->error(trans('messages.Delete'));
        return redirect()->route('students.index');
    }

    public function Get_classrooms($id)
    {
        $list_classes = Classroom::where("grade_id", $id)->pluck("name", "id");
        return $list_classes;
    }

    public function Get_Sections($id)
    {

        $list_sections = Section::where("classroom_id", $id)->pluck("name", "id");
        return $list_sections;
    }

    public function Upload_attachment($request)
    {
        foreach($request->file('photos') as $file)
        {
            $name = $file->getClientOriginalName();
            $file->storeAs('attachments/students/'.$request->student_name, $file->getClientOriginalName(),'upload_attachments');

            // insert in image_table
            $images= new Image();
            $images->filename=$name;
            $images->imageable_id = $request->student_id;
            $images->imageable_type = 'App\Models\Student';
            $images->save();
        }
        toastr()->success(trans('messages.success'));
        return redirect()->route('Students.show',$request->student_id);
    }

    public function Download_attachment($studentsname, $filename)
    {

        return response()->download(public_path('attachments/students/'.$studentsname.'/'.$filename));

    }

    public function Delete_attachment($request)
    {
        // Delete img in server disk
        Storage::disk('upload_attachments')->delete('attachments/students/'.$request->student_name.'/'.$request->filename);

        // Delete in data
        image::where('id',$request->id)->where('filename',$request->filename)->delete();

        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Students.show',$request->student_id);
    }
}
