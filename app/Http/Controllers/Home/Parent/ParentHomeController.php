<?php

namespace App\Http\Controllers\Home\Parent;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class ParentHomeController extends Controller
{
    public function index()
    {
        $sons = Student::where('parent_id',auth()->user()->id)->get();

        return view('pages.Parent.dashboard',compact('sons'));
    }
}
