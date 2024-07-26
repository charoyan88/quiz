@extends('layouts.app')

@section('title', 'Create Question')
<style>
    .green { background-color: green; color: white; }
    .red { background-color: red; color: white; }
</style>
@section('content')
    <h1>{{ $question->description }}</h1>
    <ul>
        @foreach ($question->answers as $answer)
            <button
                id="answerButton_{{ $answer->id }}"
                onclick="handleAnswerClick('{{ route('checkAnswer', $answer->id) }}', {{ $answer->id }})">
                {{ $answer->name }}
            </button>
        @endforeach
    </ul>
    <div id="timer">200 seconds remaining</div>
@endsection
@push('scripts')
    <script>
        let timer = 200;

        function startTimer() {
            const timerElement = document.getElementById('timer');
            const interval = setInterval(() => {
                timer--;
                timerElement.textContent = timer + ' seconds remaining';
                if (timer <= 0) {
                    clearInterval(interval);
                    alert("Time's up!");
                    // Handle timeout (e.g., auto-submit, show alert)
                }
            }, 1000);
        }

        function handleAnswerClick(url, answerId) {
            // Disable all buttons
            const allButtons = document.querySelectorAll('button[id^="answerButton_"]');
            allButtons.forEach(button => button.disabled = true);
            const urlWithTimer = new URL(url);
            urlWithTimer.searchParams.append('timer', timer);
            fetch(urlWithTimer)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    const isSuccess = data.success;

                    allButtons.forEach(button => {
                        if (button.id === 'answerButton_' + answerId) {
                            if (isSuccess) {
                                button.classList.add('green');
                                button.classList.remove('red');
                            } else {
                                button.classList.add('red');
                                button.classList.remove('green');
                            }
                        } else {

                            button.classList.remove('green', 'red');
                        }
                    });
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        }

        window.onload = startTimer;
    </script>
@endpush
