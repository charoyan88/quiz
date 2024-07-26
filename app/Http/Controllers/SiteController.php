<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $questions = Question::pluck('id');
        $question = Question::first();
        return view('site.index', compact('question'));
    }

    public function checkAnswer(Request $request, $id)
    {
        $timer = $request->query('timer');
        $answer = Answer::find($id);
        if ($answer->is_correct) {
            return response()->json(['success' => 'success']);
        }
        return response()->json(['error' => 'error']);
    }
}
