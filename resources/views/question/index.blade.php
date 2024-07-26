@extends('layouts.app')

@section('title', 'Questions')

@section('content')
    <h1>All Questions</h1>
    <a href="{{ route('questions.create') }}" class="btn btn-primary mb-3">Create New Question</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Description</th>
            <th>Points</th>
            <th>Total Time</th>
            <th>Time Limit</th>
            <th>Point Percent</th>
            <th>Minimal Point</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @if($questions->count())
            @foreach($questions as $question)
                <tr>
                    <td>{{ $question->description }}</td>
                    <td>{{ $question->point }}</td>
                    <td>{{ $question->time_total }}</td>
                    <td>{{ $question->time_limit }}</td>
                    <td>{{ $question->point_percent }}</td>
                    <td>{{ $question->minimal_point }}</td>
                    <td>
                        <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this question?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7">No questions found.</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection
