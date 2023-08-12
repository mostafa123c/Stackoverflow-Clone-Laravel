@extends('layouts.default')

@section('title' ,'New Question')

@section('content')

   <form action="{{route('questions.store')}}" method="post">
       @csrf
         <div class="form-group mb-3">
            <x-form-input id="title" name="title" label="Question Title" />
         </div>

         <div class="form-group mb-3">
             <x-form-textarea id="description" name="description" label="Question Description" />
         </div>

       <div class="form-group mb-3">
           <label for="description">Tags</label>
           <div>
               @foreach($tags as $tag)
                   <div class="form-check">
                       <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag-{{ $tag->id }}">
                       <label class="form-check-label" for="tag-{{ $tag->id }}">
                           {{ $tag->name }}
                       </label>
                   </div>
               @endforeach
           </div>
       </div>


         <div class="form-group">
              <div>
                <button type="submit" class="btn btn-primary">Create Question</button>
              </div>
        </div>

   </form>

@endsection

