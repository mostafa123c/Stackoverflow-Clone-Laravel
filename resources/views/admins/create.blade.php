<x-dashboard-layout>

    <x-slot name="title">
        Create Admin Role
    </x-slot>

    <x-slot name="breadcrumb">
        {{--        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>--}}
        <li class="breadcrumb-item active">Admin Roles</li>
    </x-slot>

    <x-alert/>

@include('admins._form',[
'action' => route('admins.store'),
'update' => false
])

</x-dashboard-layout>
