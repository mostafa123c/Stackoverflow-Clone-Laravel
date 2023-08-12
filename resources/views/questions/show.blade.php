@extends('layouts.default')

@section('title')
    Questions List
    <a href="{{route('questions.create')}}" class="btn btn-outline-primary btn-xs">Create New Question</a>
@endsection


@section('content')

    <x-alert/>


        <div class="card mb-3" >
            <div class="card-body">
                <h5 class="card-title">{{ $question->title }}</h5>
                <div class="text-muted mb-4">
                    Asked: {{ $question->created_at->diffForHumans() }}, By: {{ $question->user->name }}
                </div>
                <p class="card-text">{{ $question->description  }}</p>
                <div>
                    Tags:
                    <ul class="inline-list">
                    @foreach($question->tags as $tag)
                        <li>{{ $tag->name }}</li>
                    @endforeach
                    </ul>
                </div>

            </div>
        </div>

        <section>
            <h3>{{ $answers->count() }} Answers</h3>
            @forelse($answers as $answer )
                <div class="card mb-3" >
                    @if($answer->best_answer == 1)
                       <span class="badge bg-success">BEST</span>
                    @endif
                    <div class="card-body">
                        <p class="card-text">{{ $answer->description  }}</p>
                        <div class="text-muted mb-4">
                            {{ $answer->created_at->diffForHumans() }},
                            By: {{ $answer->user->name }}
                        </div>
                        @auth()
                            @if( $answer->best_answer == 0 && Auth::id() == $question->user_id)
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <form action="{{route('answers.best' , $answer->id)}}" method="post" >
                                                @csrf
                                                @method('put')
                                                <button type="submit" class="btn btn-success">Mark as best Answer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endauth

                    </div>
                </div>
            @empty
                <div class="alert alert-warning">
                    No Answers Found!
                </div>
            @endforelse
{{--            @if(Auth::check())--}}
            @auth
            <hr>
            <h3>Add Answer</h3>
            <form action="{{ route('answers.store') }}" method="post">
                @csrf

                <input type="hidden" name="question_id" value="{{ $question->id }}">

                <div class="form-group mb-3">
                    <div>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{old('description')}}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

            </form>
            @endauth
{{--            @endif--}}
            @guest
                <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">Register</a> to add answer.
            @endguest

        </section>

@endsection

