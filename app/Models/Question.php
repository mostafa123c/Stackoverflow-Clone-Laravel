<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'status', 'user_id',
    ];

    //one-to many relationship (Question has many answers)
    public function answers()
    {
        return $this->hasMany(Answer::class , 'question_id' , 'id');
    }

    //reverse one-to many relationship (Question belongs to a user)
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }

    //many-to-many relationship (Question belongs to many tags)
    public function tags()
    {
        return $this->belongsToMany(Tag::class , 'question_tag' , 'question_id' , 'tag_id' ,'id' , 'id');
//        return $this->belongsToMany(Tag::class);  //this is also correct if the table name is question_tag(correct naming convention
    }
}
