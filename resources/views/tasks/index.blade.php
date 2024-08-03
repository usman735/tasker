@extends('layouts.app')

@section('content')
    <h1>Tasks</h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create Task</a>
    <select id="project-filter">
        <option value="">All Projects</option>
        @foreach ($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
        @endforeach
    </select>
    <ul id="task-list">
        @foreach ($tasks as $task)
            <li data-id="{{ $task->id }}">{{ $task->name }} - {{ $task->project->name }}
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let taskList = document.getElementById('task-list');
            new Sortable(taskList, {
                onEnd: function (evt) {
                    let tasks = Array.from(taskList.children).map((li, index) => ({
                        id: li.dataset.id,
                        priority: index
                    }));
                    fetch('{{ route('tasks.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({tasks: tasks})
                    });
                }
            });
        });
    </script>
@endsection
