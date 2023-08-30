@extends('layouts.default')
{{-- <x-dashboard-layout> --}}
@section('title')
    Roles
    <a class="btn btn-outline-dark" href="/roles/create">Add New</a>
    <!-- <form action="" class="mb-3">
       <input  type="submit" value="" />
   </form> -->
@endsection

<x-alert />

{{-- @if(Auth::check())
User: {{$user->name}}
@endif  --}}
@section('content')
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($roles as $role)
            <tr>
                <td> {{$role->id }}</td>
                <td>{{$role->name}}</td>
                <td>{{$role->created_at}} </td>
                <td> {{$role->updated_at}} </td>
                <td>
                    <form action="{{ route('roles.edit', $role->id) }}">
                        <input class="btn btn-danger btn-sm" type="submit" value="update" />
                    </form>
                </td>
                <td>
                    <form class="delete-form" action="{{ route('roles.destroy', $role->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm">delete</button>

                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <script>
        setTimeout(function() {
            document.querySelector('.alert').style.display = "none"
        }, 3000)

        document.querySelector('.delete-form').addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm("Are you sure you want to delete this item ?")) {
                e.target.submit();
            }
        })
    </script>
@endsection


{{-- </x-dashboard-layout> --}}
