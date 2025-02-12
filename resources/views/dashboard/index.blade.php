@extends('layouts.dashboard')

@section('content')
    <h1 class="text-2xl font-bold">Welcome to Dashboard</h1>
    <p class="text-gray-600">You are logged in as {{ auth()->user()->name }} with role {{ auth()->user()->role }}</p>
@endsection
