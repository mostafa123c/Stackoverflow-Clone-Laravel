<x-dashboard-layout>

    <x-slot name="title">
        Edit Admin Role
        <a href="{{route('admins.create')}}" class="btn btn-outline-dark btn-xs">Create New Admin Role</a>
    </x-slot>

    <x-slot name="breadcrumb">
        {{--        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>--}}
        <li class="breadcrumb-item active">Roles</li>
    </x-slot>

    <x-alert/>

@include('admins._form',[
'action' => route('admins.update', $admin->id),
'update' => true
])


</x-dashboard-layout>
