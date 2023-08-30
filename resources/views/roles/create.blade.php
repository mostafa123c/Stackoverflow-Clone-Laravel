@extends('layouts.default')

@section('title')
    Create New Role
    <a class="btn btn-outline-dark" href="/roles/">HOME</a>
@endsection

{{-- @push('styles')
<link rel="stylesheet" href="style.css">
@endpush
@push('scripts')
@endpush --}}

@section('content')

    @include('roles._form',[
    'action' => route('roles.store'),
    'update' => false
    ])
@endsection
