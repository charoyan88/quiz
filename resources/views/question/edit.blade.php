@extends('layouts.app')

@section('title', 'Create Question')

@section('content')
    <h1>Update Question</h1>
    <form action="{{route('questions.update',$question->id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="description">Question:</label>
            <textarea class="form-control @error('question') is-invalid @enderror" id="description" name="description" required>{{ $question->description??old('description') }}</textarea>
            @error('question')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        @foreach ($question->answers as $answer)
            <div class="form-group">
                <label for="answer{{ $answer->id}}">Answer {{ $answer->id }}:</label>
                <input type="text" class="form-control @error('answer.' .($answer->id)) is-invalid @enderror" id="answer{{ $answer->id}}" name="answer[{{$answer->id}}]" required value="{{ $answer->name??old('answer.' . ($answer->id)) }}">
                @error('answer.' . ($answer->id))
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="correct{{ $answer->id}}" name="correct[]" value="{{ $answer->id}}" {{ $answer->is_correct ? 'checked' : '' }}>
                    <label class="form-check-label" for="correct{{ $answer->id }}">Correct Answer</label>
                </div>
            </div>
        @endforeach
        <div class="form-group">
            <label for="point">Point</label>
            <input type="text" class="form-control @error('point') is-invalid @enderror" id="point" name="point" required value="{{ $question->point??old('point') }}">
            @error('point')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="time_total">Total time</label>
            <input type="text" class="form-control @error('time_total') is-invalid @enderror" id="time_total" name="time_total" required value="{{ $question->time_total??old('time_total') }}">
            @error('time_total')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="time_limit">Time limit</label>
            <input type="text" class="form-control @error('time_limit') is-invalid @enderror" id="time_limit" name="time_limit" required value="{{ $question->time_limit??old('time_limit') }}">
            @error('time_limit')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="point_percent">Point percent</label>
            <input type="text" class="form-control @error('point_percent') is-invalid @enderror" id="point_percent" name="point_percent" required value="{{ $question->point_percent??old('point_percent') }}">
            @error('point_percent')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="minimal_point">Minimal point</label>
            <input type="text" class="form-control @error('minimal_point') is-invalid @enderror" id="minimal_point" name="minimal_point" required value="{{$question->minimal_point?? old('minimal_point') }}">
            @error('minimal_point')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
