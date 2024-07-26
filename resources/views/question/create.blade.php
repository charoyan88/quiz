@extends('layouts.app')

@section('title', 'Create Question')

@section('content')
    <h1>Create New Question</h1>
    <form action="/admin/questions" method="POST">
        @csrf
        <div class="form-group">
            <label for="description">Question:</label>
            <textarea class="form-control @error('question') is-invalid @enderror" id="description" name="description" required>{{ old('description') }}</textarea>
            @error('question')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        @for ($i = 1; $i <= 4; $i++)
            <div class="form-group">
                <label for="answer{{ $i }}">Answer {{ $i }}:</label>
                <input type="text" class="form-control @error('answer.' . ($i - 1)) is-invalid @enderror" id="answer{{ $i }}" name="answer[]" required value="{{ old('answer.' . ($i - 1)) }}">
                @error('answer.' . ($i - 1))
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="correct{{ $i }}" name="correct[]" value="{{ $i }}" {{ in_array($i, old('correct', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="correct{{ $i }}">Correct Answer</label>
                </div>
            </div>
        @endfor
        <div class="form-group">
            <label for="point">Point</label>
            <input type="text" class="form-control @error('point') is-invalid @enderror" id="point" name="point" required value="{{ old('point') }}">
            @error('point')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="time_total">Total time</label>
            <input type="text" class="form-control @error('time_total') is-invalid @enderror" id="time_total" name="time_total" required value="{{ old('time_total') }}">
            @error('time_total')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="time_limit">Time limit</label>
            <input type="text" class="form-control @error('time_limit') is-invalid @enderror" id="time_limit" name="time_limit" required value="{{ old('time_limit') }}">
            @error('time_limit')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="point_percent">Point percent</label>
            <input type="text" class="form-control @error('point_percent') is-invalid @enderror" id="point_percent" name="point_percent" required value="{{ old('point_percent') }}">
            @error('point_percent')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="minimal_point">Minimal point</label>
            <input type="text" class="form-control @error('minimal_point') is-invalid @enderror" id="minimal_point" name="minimal_point" required value="{{ old('minimal_point') }}">
            @error('minimal_point')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
