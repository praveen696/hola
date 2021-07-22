@extends('layout')

@section('content')
    <form action="{{ route('signin') }}" method="post">
        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        @if($errors->any())
            <div class="text-error">{{$errors->first()}}</div>
        @endif
        {{ csrf_field() }}
        <button type="submit">Sign In</button>
    </form>
   
@endsection