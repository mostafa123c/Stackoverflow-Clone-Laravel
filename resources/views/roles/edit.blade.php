@extends('layouts.default')

@section('title' )
    Edit Role
    <a class="btn btn-outline-dark" href="/roles/">Roles</a>
@endsection
@section('content')

    @include('roles._form',[
    'action' => route('roles.update', $role->id),
    'update' => true
    ])


@endsection
