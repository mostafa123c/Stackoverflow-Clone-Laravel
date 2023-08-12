@extends('layouts.default')

@section('title' ,'Edit Question')

@section('content')

    <form action="{{route('questions.update' , $question->id )}}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <x-form-input :value="$question->title" id="title" name="title" label="Question Title" />
        </div>

        <div class="form-group mb-3">
            <x-form-textarea :value="$question->description" id="description" name="description" label="Question Description" />
        </div>

        <div class="form-group mb-3">
            <label for="description">Tags</label>
            <div>
                @foreach($tags as $tag)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag-{{ $tag->id }}" @if(in_array($tag->id , $question_tags)) checked @endif>
                        <label class="form-check-label" for="tag-{{ $tag->id }}">
                            {{ $tag->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>


        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-primary">Update Question</button>
            </div>
        </div>

    </form>

@endsection

