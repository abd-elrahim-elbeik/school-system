<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Fee_invoice;
use App\Models\Grade;
use App\Models\Student;
use App\Models\StudentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeesInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Fee_invoices = Fee_invoice::all();
        $Grades = Grade::all();

        return view('pages.Fees_Invoices.index',compact('Fee_invoices','Grades'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $List_Fees = $request->List_Fees;

        DB::beginTransaction();

        try {

            foreach ($List_Fees as $List_Fee) {

                // save data in fee invoice table
                $Fees = new Fee_invoice();
                $Fees->invoice_date = date('Y-m-d');
                $Fees->student_id = $List_Fee['student_id'];
                $Fees->grade_id = $request->Grade_id;
                $Fees->classroom_id = $request->Classroom_id;;
                $Fees->fee_id = $List_Fee['fee_id'];
                $Fees->amount = $List_Fee['amount'];
                $Fees->description = $List_Fee['description'];
                $Fees->save();

                // save data in student account table

                $StudentAccount = new StudentAccount();
                $StudentAccount->date = date('Y-m-d');
                $StudentAccount->type = 'invoice';
                $StudentAccount->fee_invoice_id = $Fees->id;
                $StudentAccount->student_id = $List_Fee['student_id'];
                $StudentAccount->debit = $List_Fee['amount'];
                $StudentAccount->credit = 0.00;
                $StudentAccount->description = $List_Fee['description'];
                $StudentAccount->save();
            }

            DB::commit();

            toastr()->success(trans('messages.success'));
            return redirect()->route('fees_invoices.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::findorfail($id);
        $fees = Fee::where('classroom_id',$student->classroom_id)->get();

        return view('pages.Fees_Invoices.create',compact('student','fees'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fee_invoices = Fee_invoice::findorfail($id);

        $fees = Fee::where('classroom_id',$fee_invoices->classroom_id)->get();

        return view('pages.Fees_Invoices.edit',compact('fee_invoices','fees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {

            // update data in fee invoice table
            $Fees = Fee_invoice::findorfail($request->id);
            $Fees->fee_id = $request->fee_id;
            $Fees->amount = $request->amount;
            $Fees->description = $request->description;
            $Fees->save();

            // update data in Student Account table
            $StudentAccount = StudentAccount::where('fee_invoice_id',$request->id)->first();
            $StudentAccount->Debit = $request->amount;
            $StudentAccount->description = $request->description;
            $StudentAccount->save();
            DB::commit();

            toastr()->success(trans('messages.Update'));
            return redirect()->route('fees_invoices.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {

            Fee_invoice::destroy($request->id);

            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
