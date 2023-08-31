<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Notifications\NewAnswerNotification;
use Auth;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index' , 'show');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $question_id = $request->query('question_id');
        if (!$question_id) {
            return Response()->json([
                'messsage' => 'Missing Question Id'
            ], 422);
        }
        $answers = Answer::where('question_id', '=', $question_id)
            ->with('user')
            ->paginate();
        return $answers;
    }

    /**
     * Store a newly created resource in storage.
     */
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
        $question->user->notify(new NewAnswerNotification($question , auth::user() ));

        return Response()->json([
            'messsage' => 'Answer submitted successfully.'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $answer = Answer::findOrFail($id);
        return response()->json($answer->load('question' , 'user') , 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $answer = Answer::findOrFail($id);

        $request->validate([
            'description' => 'required|string|min:5',
        ]);

        if($answer->user_id != auth::id()){
            return Response()->json([
                'messsage' => 'You are not authorized to edit this answer.'
            ], 403);
        }

        $answer->update($request->all());

        return Response()->json([
            'messsage' => 'Answer updated successfully.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $answer = Answer::findOrFail($id);

        if($answer->user_id != auth::id()){
            return Response()->json([
                'messsage' => 'You are not authorized to delete this answer.'
            ], 403);
        }

        $answer->delete();

        return Response()->json([
            'messsage' => 'Answer deleted successfully.'
        ], 200);
    }
}
