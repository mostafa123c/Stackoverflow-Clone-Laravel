<x-dashboard-layout>

    <x-slot name="title">
        Edit Role
        <a href="{{route('roles.create')}}" class="btn btn-outline-dark btn-xs">Create New Role</a>
    </x-slot>

    <x-slot name="breadcrumb">
        {{--        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>--}}
        <li class="breadcrumb-item active">Roles</li>
    </x-slot>

    <x-alert/>

@include('roles._form',[
'action' => route('roles.update', $role->id),
'update' => true
])


</x-dashboard-layout>
