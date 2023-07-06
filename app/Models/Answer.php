<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    //Reverse One-to many relationship (Answer belongs to a question)
    public function question()
    {
        return $this->belongsTo(Question::class , 'question_id' , 'id');
    }

    //Reverse One-to many relationship (Answer belongs to a user)
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
}
