@extends('layout')

@section('content')
    <h1>{{isset($user) ? 'Edit User' : 'Add user'}}</h1>
    <a href="{{route('users')}}">View users</a>
    <form 
    action="{{ isset($user) ? route('users.edit.post', ['id' => $user->id]) : route('users.create.post') }}"
    method="POST">
        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" required id="username" name="username" value="{{old('username', $user->username ?? '')}}">
        </div>
        <div class="input-group">
            <label for="username">name</label>
            <input type="text" required id="name" name="name" value="{{old('name', $user->name ?? '')}}">
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" required id="password" name="password" value="{{old('password', $user->password ?? '')}}">
        </div>
        <div class="input-group">
            <label for="username">Role</label>
            <select name="role" required>
                <option value="">Select Role</option>
                @foreach ($roles as $role)
                    <option value="{{$role->id}}"
                        @if ($role->id == old('role', (isset($user) && $user->roles && $user->roles[0] ? $user->roles[0]->id : '')));
                            selected="selected"
                        @endif
                    >{{$role->name}}</option>
                @endforeach
            </select>
        </div>
        {{ csrf_field() }}
        <button type="submit">Save</button>
    </form>
    @if (count($errors) > 0)
         <div class = "alert alert-danger">
            <ul class="error-wrapper">
               @foreach ($errors->all() as $error)
                  <li class="text-error">{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif
    
@endsection