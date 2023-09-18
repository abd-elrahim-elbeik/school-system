<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\FundAccount;
use App\Models\PaymentStudent;
use App\Models\Student;
use App\Models\StudentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payment_students = PaymentStudent::all();
        return view('pages.Payment.index',compact('payment_students'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            // save data in Payment Student table
            $payment_students = new PaymentStudent();
            $payment_students->date = date('Y-m-d');
            $payment_students->student_id = $request->student_id;
            $payment_students->amount = $request->Debit;
            $payment_students->description = $request->description;
            $payment_students->save();


            // save data in Fund Account table
            $fund_accounts = new FundAccount();
            $fund_accounts->date = date('Y-m-d');
            $fund_accounts->payment_id = $payment_students->id;
            $fund_accounts->debit = 0.00;
            $fund_accounts->credit = $request->Debit;
            $fund_accounts->description = $request->description;
            $fund_accounts->save();


            // save data in Student Account table
            $students_accounts = new StudentAccount();
            $students_accounts->date = date('Y-m-d');
            $students_accounts->type = 'payment';
            $students_accounts->student_id = $request->student_id;
            $students_accounts->payment_id = $payment_students->id;
            $students_accounts->debit = $request->Debit;
            $students_accounts->credit = 0.00;
            $students_accounts->description = $request->description;
            $students_accounts->save();

            DB::commit();
            toastr()->success(trans('messages.success'));
            return redirect()->route('Payment_students.index');
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
        return view('pages.Payment.create',compact('student'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment_student = PaymentStudent::findorfail($id);
        return view('pages.Payment.edit',compact('payment_student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        try {

            // update data in Payment Student table
            $payment_students = PaymentStudent::findorfail($request->id);
            $payment_students->date = date('Y-m-d');
            $payment_students->student_id = $request->student_id;
            $payment_students->amount = $request->Debit;
            $payment_students->description = $request->description;
            $payment_students->save();


            // update data in Fund Account table
            $fund_accounts = FundAccount::where('payment_id',$request->id)->first();
            $fund_accounts->date = date('Y-m-d');
            $fund_accounts->payment_id = $payment_students->id;
            $fund_accounts->Debit = 0.00;
            $fund_accounts->credit = $request->Debit;
            $fund_accounts->description = $request->description;
            $fund_accounts->save();


            // update data in Student Account table
            $students_accounts = StudentAccount::where('payment_id',$request->id)->first();
            $students_accounts->date = date('Y-m-d');
            $students_accounts->type = 'payment';
            $students_accounts->student_id = $request->student_id;
            $students_accounts->payment_id = $payment_students->id;
            $students_accounts->Debit = $request->Debit;
            $students_accounts->credit = 0.00;
            $students_accounts->description = $request->description;
            $students_accounts->save();
            DB::commit();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Payment_students.index');
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
            PaymentStudent::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
