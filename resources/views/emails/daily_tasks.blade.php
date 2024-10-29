<h1>Your Pending Tasks for Today</h1>
@foreach ($tasks as $task)
    <p>{{ $task->title }} - {{ $task->due_date }}</p>
@endforeach
