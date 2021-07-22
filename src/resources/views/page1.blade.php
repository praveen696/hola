@extends('layout')

@section('content')
    <h1>Hello 1 {{\Auth::user()->name}}</h1>
@endsection