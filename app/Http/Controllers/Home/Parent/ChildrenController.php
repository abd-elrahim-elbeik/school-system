<?php

namespace App\Http\Controllers\Home\Parent;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Degree;
use App\Models\Fee_invoice;
use App\Models\ReceiptStudent;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChildrenController extends Controller
{
    public function index()
    {

        $students = Student::where('parent_id', auth()->user()->id)->get();

        return view('pages.Parent.Children.index', compact('students'));
    }

    public function results($id)
    {

        $student = Student::findorFail($id);

        if ($student->parent_id !== auth()->user()->id) {
            toastr()->error('يوجد خطا في كود الطالب');
            return redirect()->route('sons.index');
        }
        $degrees = Degree::where('student_id', $id)->get();

        if ($degrees->isEmpty()) {
            toastr()->error('لا توجد نتائج لهذا الطالب');
            return redirect()->route('sons.index');
        }

        return view('pages.Parent.Degrees.index', compact('degrees'));

    }

    public function attendances()
    {
        $students = Student::where('parent_id', auth()->user()->id)->get();

        return view('pages.Parent.Attendance.index', compact('students'));
    }


    public function attendanceSearch(Request $request)
    {
        $request->validate([
            'from' => 'required|date|date_format:Y-m-d',
            'to' => 'required|date|date_format:Y-m-d|after_or_equal:from'
        ], [
            'to.after_or_equal' => 'تاريخ النهاية لابد ان اكبر من تاريخ البداية او يساويه',
            'from.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
            'to.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
        ]);

        $ids = DB::table('section_teacher')->where('teacher_id', auth()->user()->id)->pluck('section_id');
        $students = Student::whereIn('section_id', $ids)->get();

        if ($request->student_id == 0) {

            $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])->get();

            return view('pages.Parent.Attendance.index', compact('Students', 'students'));

        } else {

            $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])
                ->where('student_id', $request->student_id)->get();
            return view('pages.Parent.Attendance.index', compact('Students', 'students'));

        }

    }

    public function fees(){

        $students_ids = Student::where('parent_id', auth()->user()->id)->pluck('id');
        
        $Fee_invoices = Fee_invoice::whereIn('student_id',$students_ids)->get();

        return view('pages.Parent.Fees.index', compact('Fee_invoices'));

    }

    public function receiptStudent($id){

        $student = Student::findorFail($id);
        if ($student->parent_id !== auth()->user()->id) {
            toastr()->error('يوجد خطا في كود الطالب');
            return redirect()->route('sons.fees');
        }

        $receipt_students = ReceiptStudent::where('student_id',$id)->get();

        if ($receipt_students->isEmpty()) {
            toastr()->error('لا توجد مدفوعات لهذا الطالب');
            return redirect()->route('sons.fees');
        }
        return view('pages.Parent.Receipt.index', compact('receipt_students'));

    }
}
