<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Library::all();
        return view('pages.library.index',compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grades = Grade::all();
        return view('pages.library.create',compact('grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'file_name' => 'required',
            'Grade_id' => 'required',
            'Classroom_id' => 'required',
            'section_id' => 'required',
        ]);

        try {
            $books = new Library();
            $books->title = $request->title;
            $books->file_name =  $request->file('file_name')->getClientOriginalName();
            $books->grade_id = $request->Grade_id;
            $books->classroom_id = $request->Classroom_id;
            $books->section_id = $request->section_id;
            $books->teacher_id = 1;
            $books->save();

            $request->file('file_name')->storeAs('attachments/library/', $request->file('file_name')->getClientOriginalName(),'upload_attachments');

            toastr()->success(trans('messages.success'));
            return redirect()->route('library.index');

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $grades = Grade::all();
        $book = library::findorFail($id);
        return view('pages.library.edit',compact('book','grades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'Grade_id' => 'required',
            'Classroom_id' => 'required',
            'section_id' => 'required',
        ]);

        try {

            $book = library::findorFail($request->id);
            $book->title = $request->title;

            if($request->hasfile('file_name')){

                Storage::disk('upload_attachments')->delete('attachments/library/'.$book->file_name);

                $request->file('file_name')->storeAs('attachments/library/', $request->file('file_name')->getClientOriginalName(),'upload_attachments');

                // $file_name_new = $request->file('file_name')->getClientOriginalName();
                $book->file_name = $request->file('file_name')->getClientOriginalName();
            }

            $book->Grade_id = $request->Grade_id;
            $book->classroom_id = $request->Classroom_id;
            $book->section_id = $request->section_id;
            $book->teacher_id = 1;
            $book->save();

            toastr()->success(trans('messages.Update'));
            return redirect()->route('library.index');

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Storage::disk('upload_attachments')->delete('attachments/library/'.$request->file_name);

        $this->deleteFile($request->file_name);
        library::destroy($request->id);
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('library.index');
    }

    public function downloadAttachment($filename)
    {
        return response()->download(public_path('attachments/library/'.$filename));
    }
}
