<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Tag;
use Auth;
use DB;
use Illuminate\Http\Request;
use Throwable;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
//        $questions = Question::all();
//        $questions = Question::paginate(1);

        $user_id = $request->query('user_id');
        $tags = explode(',', $request->query('tags'));

        $questions = Question::with('user', 'tags')
            ->when($user_id, function ($query, $user_id) {
                $query->where('user_id','=' , $user_id);
            })
            ->when($tags, function ($query, $tags) {
                $query->whereHas('tags', function ($query) use ($tags) {
                    $query->whereIn('id', $tags);
                });
            })
            ->paginate(5);
        return $questions;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'tags.*' => ['required', 'int', 'exists:tags,id']
        ]);

        $request->merge([
            'user_id' => Auth::id(),
        ]);

        DB::beginTransaction();
        try {
            $question = Question::create($request->all());
            $question->tags()->attach($request->input('tags'));
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
        }

        return response()->json($question, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $question = Question::findOrFail($id);
        return $question->load('tags', 'user');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $question = Question::findOrFail($id);
        $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'required', 'string'],
            'status' => ['in:open,closed'],
//            'tags' => ['sometimes','required','array'],
            'tags' => ['sometimes', 'required', function ($attr, $value, $fail) {
                $tags = explode(',', $value);
                $exists = Tag::whereIn('id', $tags)->pluck('id')->toArray();
                $result = array_intersect($exists, $tags);
                if (count($result) != count($tags)) {
                    $fail('Invalid tags');
                }
            }],
        ]);

        DB::beginTransaction();
        try {
            $question->update($request->all());

            $tags = explode(',', $request->input('tags'));

            $question->tags()->sync($tags);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return [
            'message' => 'Question Updated',
            'question' => $question,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Question::destroy($id);
        return response()->json([
            'message' => 'Question deleted successfully'
        ], 204);
    }
}
