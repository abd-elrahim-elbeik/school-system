<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Traits\MeetingZoomTrait;
use App\Models\Grade;
use App\Models\OnlineClasse;
use Illuminate\Http\Request;
use MacsiDigital\Zoom\Facades\Zoom;

class OnlineClasseController extends Controller
{
    use MeetingZoomTrait;
    public function index()
    {
        $online_classes = OnlineClasse::all();
        return view('pages.online_classes.index', compact('online_classes'));
    }


    public function create()
    {
        $Grades = Grade::all();
        return view('pages.online_classes.add', compact('Grades'));
    }


    public function store(Request $request)
    {
        // try {

            $meeting = $this->createMeeting($request);
            OnlineClasse::create([
                'Grade_id' => $request->Grade_id,
                'Classroom_id' => $request->Classroom_id,
                'section_id' => $request->section_id,
                'user_id' => auth()->user()->id,
                'meeting_id' => $meeting->id,
                'topic' => $request->topic,
                'start_at' => $request->start_time,
                'duration' => $meeting->duration,
                'password' => $meeting->password,
                'start_url' => $meeting->start_url,
                'join_url' => $meeting->join_url,
            ]);
            toastr()->success(trans('messages.success'));
            return redirect()->route('online_classes.index');
        // } catch (\Exception $e) {
            // return redirect()->back()->with(['error' => $e->getMessage()]);
        // }

    }

    public function destroy(Request $request)
    {
        try {
            $meeting = Zoom::meeting()->find($request->id);
            $meeting->delete();
            OnlineClasse::where('meeting_id', $request->id)->delete();
            toastr()->success(trans('messages.Delete'));
            return redirect()->route('online_classes.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }
}
