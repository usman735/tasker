@extends('layouts.app')

@section('content')
    <h1>Edit Task</h1>
    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Task Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $task->name }}" required>
        </div>
        <div class="form-group">
            <label for="project_id">Project:</label>
            <select name="project_id" id="project_id" class="form-control" required>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}" @if($task->project_id == $project->id) selected @endif>{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
