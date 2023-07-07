<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|int|exists:questions,id',
            'description' => 'required|string|min:5',
        ]);
        $request->merge([
            'user_id' => auth::id(),
        ]);

        $question = Question::findOrFail($request->input('question_id'));

        $question->answers()->create($request->all());

        return redirect()->route('questions.show', $question->id)
            ->with('success', 'Answer submitted successfully.');
    }
}
