<x-dashboard-layout>

    <x-slot name="title">
        Create Role
    </x-slot>

    <x-slot name="breadcrumb">
        {{--        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>--}}
        <li class="breadcrumb-item active">Roles</li>
    </x-slot>

    <x-alert/>

@include('roles._form',[
'action' => route('roles.store'),
'update' => false
])

</x-dashboard-layout>
