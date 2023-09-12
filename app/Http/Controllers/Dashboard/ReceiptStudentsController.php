<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\FundAccount;
use App\Models\ReceiptStudent;
use App\Models\Student;
use App\Models\StudentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiptStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $receipt_students = ReceiptStudent::all();
        return view('pages.Receipt.index',compact('receipt_students'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            // save data in Receipt Student table
            $receipt_students = new ReceiptStudent();
            $receipt_students->date = date('Y-m-d');
            $receipt_students->student_id = $request->student_id;
            $receipt_students->debit = $request->Debit;
            $receipt_students->description = $request->description;
            $receipt_students->save();

            // save data in Fund Account table
            $fund_accounts = new FundAccount();
            $fund_accounts->date = date('Y-m-d');
            $fund_accounts->receipt_id = $receipt_students->id;
            $fund_accounts->debit = $request->Debit;
            $fund_accounts->credit = 0.00;
            $fund_accounts->description = $request->description;
            $fund_accounts->save();

            // save data in Student Account table
            $fund_accounts = new StudentAccount();
            $fund_accounts->date = date('Y-m-d');
            $fund_accounts->type = 'receipt';
            $fund_accounts->receipt_id = $receipt_students->id;
            $fund_accounts->student_id = $request->student_id;
            $fund_accounts->debit = 0.00;
            $fund_accounts->credit = $request->Debit;
            $fund_accounts->description = $request->description;
            $fund_accounts->save();

            DB::commit();
            toastr()->success(trans('messages.success'));
            return redirect()->route('receipt_students.index');

        }

        catch (\Exception $e) {
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
        return view('pages.Receipt.create',compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $receipt_student = ReceiptStudent::findorfail($id);
        return view('pages.Receipt.edit',compact('receipt_student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        DB::beginTransaction();

        try {

            // update data in Receipt Student table
            $receipt_students = ReceiptStudent::findorfail($request->id);
            $receipt_students->date = date('Y-m-d');
            $receipt_students->student_id = $request->student_id;
            $receipt_students->Debit = $request->Debit;
            $receipt_students->description = $request->description;
            $receipt_students->save();

            // update data in Fund Account Fee table
            $fund_accounts = FundAccount::where('receipt_id',$request->id)->first();
            $fund_accounts->date = date('Y-m-d');
            $fund_accounts->receipt_id = $receipt_students->id;
            $fund_accounts->Debit = $request->Debit;
            $fund_accounts->credit = 0.00;
            $fund_accounts->description = $request->description;
            $fund_accounts->save();

            // update data in Student Account Fee table
            $fund_accounts = StudentAccount::where('receipt_id',$request->id)->first();
            $fund_accounts->date = date('Y-m-d');
            $fund_accounts->type = 'receipt';
            $fund_accounts->student_id = $request->student_id;
            $fund_accounts->receipt_id = $receipt_students->id;
            $fund_accounts->Debit = 0.00;
            $fund_accounts->credit = $request->Debit;
            $fund_accounts->description = $request->description;
            $fund_accounts->save();


            DB::commit();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('receipt_students.index');
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
            ReceiptStudent::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
