<?php

namespace App\Http\Controllers\Home\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'answers' => 'required',
            'right_answer' => 'required',
            'score' => 'required',
        ]);

        try {
            $question = new Question();
            $question->title = $request->title;
            $question->answers = $request->answers;
            $question->right_answer = $request->right_answer;
            $question->score = $request->score;
            $question->quizze_id = $request->quizz_id;
            $question->save();

            toastr()->success(trans('messages.success'));
            return redirect()->route('quizzes.show',$request->quizz_id);

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function show($id)
    {
        $quizz_id = $id;

        return view('pages.Teachers.dashboard.Questions.create', compact('quizz_id'));
    }


    public function edit($id)
    {
        $question = Question::findorFail($id);

        return view('pages.Teachers.dashboard.Questions.edit', compact('question'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'answers' => 'required',
            'right_answer' => 'required',
            'score' => 'required',
        ]);

        try {
            $question = Question::findorfail($id);
            $question->title = $request->title;
            $question->answers = $request->answers;
            $question->right_answer = $request->right_answer;
            $question->score = $request->score;
            $question->save();

            toastr()->success(trans('messages.Update'));
            return redirect()->back();

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        try {
            Question::destroy($id);

            toastr()->error(trans('messages.Delete'));
            return redirect()->back();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
