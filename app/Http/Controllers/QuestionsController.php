<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth')->except('index' , 'show');
    }

    public function index()
    {
//             leftjoin('users' , 'questions.user_id' , '=' , 'users.id')
//            ->select('questions.*' , 'users.name as user_name')
        $questions = Question::with('user')            //eager loading (good for performance)
            ->withCount('answers')
            ->latest()
            ->paginate(3);  //default 15
        return view('questions.index' , compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $request->merge([
            'user_id' => auth()->id(),
            'status' => 'open',
        ]);

        $question = Question::create($request->all());

        return redirect()->route('questions.index')
            ->with('success' , 'Question Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
//        leftjoin('users' , 'questions.user_id' , '=' , 'users.id')
//            ->select('questions.*' , 'users.name as user_name')

        $question = Question::findOrFail($id);
        $answers = $question->answers()->with('user')->latest()->get();
        return view('questions.show' , compact('question' , 'answers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $question = Question::findOrFail($id);
        return view('questions.edit' , compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'in:open,closed',
        ]);

        $question = Question::findOrFail($id);
        $question->update($request->all());

        return redirect()->route('questions.index')
            ->with('success' , 'Question Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
//        $question = Question::findOrFail($id);
//        $question->delete();
        Question::destroy($id);

        return redirect()->route('questions.index')
            ->with('success' , 'Question Deleted Successfully');
    }
}
