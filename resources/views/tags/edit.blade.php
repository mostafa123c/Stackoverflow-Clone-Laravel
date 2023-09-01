<x-dashboard-layout>

    <x-slot name="title">
        Edit Tag
        <a href="/tags/create" class="btn btn-outline-dark btn-xs">Create New Tag</a>

    </x-slot>

    <x-slot name="breadcrumb">
        {{--        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>--}}
        <li class="breadcrumb-item active">Tags</li>
    </x-slot>

    <x-alert/>

    @include('tags._form' , [
        'action' => '/tags/' . $tag->id,
        'method' => 'PUT',
        'tag' => $tag
    ])

</x-dashboard-layout>
