<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SiteController extends Controller
{
    public function index()
    {
        return view('site.index');
    }

    public function student(Request $request)
    {
        try {
            $student = Student::create(['full_name' => $request->full_name]);
            $question = Question::first();
            Session::flush();
            Session::put('student_id', $student->id);
            return redirect()->route('question', $question->id);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function question($id)
    {
        $question = Question::find($id);
        return view('site.question', compact('question'));
    }

    public function checkAnswer(Request $request, $id)
    {
        $time = $request->query('timer');
        $answer = Answer::find($id);
        $student = Student::find(Session::get('student_id'));
        if ($answer->is_correct) {
            $question = $answer->question;
            $answerTime = $question->time_total - $time;
            if ($answerTime <= 0) {
                return response()->json(['success' => 'success']);
            }
            $answerPoint = $question->point - (int)($answerTime / $question->time_limit) * $question->point * $question->point_percent / 100;
            $answerPoint = $answerPoint < $question->minimal_point ? $question->minimal_point : $answerPoint;
            $student->rate += $answerPoint;
            $student->save();
            return response()->json(['success' => 'success']);
        }
        return response()->json(['error' => 'error']);
    }

    public function result()
    {
        $studentId = Session::get('student_id');
        $student = Student::find($studentId);
        return view('site.result', compact('student'));
    }
}
