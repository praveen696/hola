@extends('layout')

@section('content')
    <h1>Hola!</h1>
    <p>Welcome to Hola! Magazine</p>

    <ul>
        <li><a href="{{route('users')}}">Users</a></li>
        <li><a href="{{route('page1')}}">Page 1</a></li>
        <li><a href="{{route('page2')}}">Page 2</a></li>
    </ul>
@endsection