<x-dashboard-layout>

    <x-slot name="title">
        Create Tags
    </x-slot>

    <x-slot name="breadcrumb">
        {{--        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>--}}
        <li class="breadcrumb-item active">Tags</li>
    </x-slot>

    <x-alert/>


    @include('tags._form' , [
        'action' => '/tags',
        'method' => 'POST'

    ])

</x-dashboard-layout>
