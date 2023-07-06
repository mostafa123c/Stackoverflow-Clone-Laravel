@extends('layouts.default')

@section('title' , 'Edit Tag')

@section('content')

    @include('tags._form' , [
        'action' => '/tags/' . $tag->id,
        'method' => 'PUT',
        'tag' => $tag
    ])

@endsection
