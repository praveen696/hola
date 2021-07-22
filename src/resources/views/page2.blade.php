@extends('layout')

@section('content')
    <h1>Hello 2 {{\Auth::user()->name}}</h1>
@endsection