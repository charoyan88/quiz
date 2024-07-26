<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{

    public function index()
    {
        $questions = Question::all();
        return view('question.index',compact('questions'));
    }

    public function create()
    {
        return view('question.create');
    }

    public function store(QuestionRequest $request)
    {
        try {
            $validated = $request->validated();
            if ($validated['minimal_point'] >= ($validated['point'] / 10)) {
                return redirect()->back()->withErrors(['minimal_point' => 'The minimal point must be less than point divided by 10.'])->withInput();
            }
            $question = Question::create(
                $request->except('answer','correct','_token')
            );
            foreach ($validated['answer'] as $index => $answerText) {
                $isCorrect = in_array($index + 1, $validated['correct']);

                Answer::create([
                    'question_id' => $question->id,
                    'name' => $answerText,
                    'is_correct' => $isCorrect,
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
        }

        return redirect()->route('questions.index');
    }

    public function show($id)
    {
        return view('question.show', compact('id'));
    }

    public function edit($id)
    {
        $question = Question::find($id);
        return view('question.edit', compact('question'));
    }

    public function update(QuestionRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            if ($validated['minimal_point'] >= ($validated['point'] / 10)) {
                return redirect()->back()->withErrors(['minimal_point' => 'The minimal point must be less than point divided by 10.'])->withInput();
            }
            $question = Question::findOrFail($id);
            $question->update($request->except('answer', 'correct', '_token'));

            Answer::where('question_id', $question->id)->delete();

            foreach ($validated['answer'] as $index => $answerText) {
                $isCorrect = in_array($index + 1, $validated['correct']);

                Answer::create([
                    'question_id' => $question->id,
                    'name' => $answerText,
                    'is_correct' => $isCorrect,
                ]);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
        }

        return redirect()->route('questions.index');
    }

    public function destroy($id)
    {
        Question::destroy($id);
        return redirect()->route('questions.index');
    }
}
