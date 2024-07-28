@extends('layouts.app')

@section('title', 'Create Student')
@section('content')
    <form action="{{route('student.create')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="full_name">Full Name</label>
                <input type="text" name = 'full_name' class="form-control" required value="{{ old('full_name') }}">
        </div>
        <button type="submit" class="btn btn-success">Start</button>
    </form>
@endsection
