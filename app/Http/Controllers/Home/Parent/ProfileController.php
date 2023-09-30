<?php

namespace App\Http\Controllers\Home\Parent;

use App\Http\Controllers\Controller;
use App\Models\MyParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {

        $information = MyParent::findorFail(auth()->user()->id);

        return view('pages.Parent.profile', compact('information'));

    }

    public function update(Request $request, $id)
    {

        $information = MyParent::findorFail($id);

        if (!empty($request->password)) {

            $information->Name_Father = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $information->password = Hash::make($request->password);
            $information->save();

        } else {

            $information->Name_Father = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $information->save();
        }

        toastr()->success(trans('messages.Update'));
        return redirect()->back();


    }
}
