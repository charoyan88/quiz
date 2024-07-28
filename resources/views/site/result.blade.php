@extends('layouts.app')

@section('title', 'Create Student')
@section('content')
    <div class="container">
        <h1>Result</h1>
        <p>Total Score: {{ $student->rate }}</p>
    </div>
@endsection
