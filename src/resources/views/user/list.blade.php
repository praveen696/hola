@extends('layout')

@section('content')
    <h1>Users</h1>
    <a href="{{route('users.create')}}">Add user</a>
    <table>
        <thead>
            <th>Name</th>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @if($users && count($users))
                @foreach ($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->username}}</td>
                        <td>{{$user->roles[0]->name}}</td>
                        <td><a href="{{route('users.edit', ['id' => $user->id])}}">Edit</a>
                        <td><a href="{{route('users.delete', ['id' => $user->id])}}">Delete</a>
                    </tr>
                @endforeach
            @else 
                <tr>
                    <td colspan="4">No users added. Please click on add user to create a new user</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection