<x-dashboard-layout>

    <x-slot name="title">
        Roles
        <a href="{{route('admins.create')}}" class="btn btn-outline-dark btn-xs">Create New Admin Role</a>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Admin Roles</li>
    </x-slot>

    <x-alert/>

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Type</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($admins as $admin)
            <tr>
                <td> {{$admin->name }}</td>
                <td>{{$admin->email}}</td>
                <td>{{$admin->type}}</td>
                <td>{{$admin->roles->pluck('name')}}</td>
                <td>{{$admin->created_at}} </td>
                <td> {{$admin->updated_at}} </td>
                <td>
                    <form action="{{ route('admins.edit', $admin->id) }}">
                        <input class="btn btn-danger btn-sm" type="submit" value="update" />
                    </form>
                </td>
                <td>
                    <form class="delete-form" action="{{ route('admins.destroy', $admin->id) }}" method="post">
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

 </x-dashboard-layout>
