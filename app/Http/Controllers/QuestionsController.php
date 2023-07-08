<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

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
        $search = request('search');
        $tag_id = request('tag_id');

        $questions = Question::with('user' , 'tags')            //eager loading (good for performance)
            ->withCount('answers')
            ->latest()
            ->when($search , function ($query , $search){
               $query->where('title' , 'LIKE' , "%{$search}%")
                    ->orWhere('description' , 'LIKE' , "%{$search}%");
            })
            ->when($tag_id , function ($query , $tag_id){
                // $query->whereRaw('questions.id IN (
                //     SELECT question_id FROM question_tag WHERE tag_id = ?
                // )', [$tag_id]);
                $query->whereHas('tags' , function ($query) use ($tag_id){
                    $query->where('id' , $tag_id);
                });
            })
            ->paginate(3);  //default 15
        return view('questions.index' , compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        return view('questions.create' , compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'required|array',
        ]);

        $request->merge([
            'user_id' => auth()->id(),
            'status' => 'open',
        ]);

        DB::beginTransaction();
        try{
            $question = Question::create($request->all());
            $question->tags()->attach($request->input('tags')); //many to many
            DB::commit();
        } catch (Throwable $e){
            DB::rollBack();
            throw $e;
        }


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
        $tags = Tag::all();

        $question_tags = $question->tags()->pluck('id')->toArray();

        return view('questions.edit' , compact('question' , 'tags' , 'question_tags'));
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
            'tags' => 'required|array',
        ]);

        $question = Question::findOrFail($id);


        DB::beginTransaction();
        try {
            $question->update($request->all());
            //add with delete old
            $question->tags()->sync($request->input('tags'));
            //add without delete old
            //$question->tags()->attach($request->input('tags'));
            //delete without add new
            //$question->tags()->detach($request->input('tags'));
            //add the doesn't exist , delete the exist values
            //$question->tags()->toggle($request->input('tags'));
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

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
