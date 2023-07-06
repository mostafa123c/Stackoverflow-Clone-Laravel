@extends('layouts.default')

{{--@push('styles')--}}
{{--    <link rel="stylesheet" href="/css/app.css">--}}
{{--@endpush--}}

@section('title' , 'Create Tag')

@section('content')

    @include('tags._form' , [
        'action' => '/tags',
        'method' => 'POST'

    ])

@endsection
