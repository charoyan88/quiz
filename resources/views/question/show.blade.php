@extends('layouts.app')

@section('title', 'Question Details')

@section('content')
    <h1>Question Details (ID: {{ $id }})</h1>
    <a href="{{ route('questions.edit', $id) }}">Edit Question</a>
    <form action="{{ route('questions.destroy', $id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Delete Question</button>
    </form>
@endsection
