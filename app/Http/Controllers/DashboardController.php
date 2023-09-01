<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::count();
        $questions = Question::count();
        $answers = Answer::count();
        $tags = Tag::count();
        $roles = Tag::count();

        return view('dashboard.index' , compact('users' , 'questions' , 'answers' , 'tags' , 'roles'));
    }
}
