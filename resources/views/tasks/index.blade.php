@extends('layouts.app')

@section('content')
    <h1>Tasks</h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Create Task</a>
    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Create Project</a>
    <div class="mb-3">
        <label for="project-filter" class="form-label">Filter by Project</label>
        <select id="project-filter" class="form-select">
            <option value="">All Projects</option>
            @foreach ($projects as $project)
                <option value="{{ $project->id }}" {{ request('project') == $project->id ? 'selected' : '' }}>
                    {{ $project->name }}
                </option>
            @endforeach
        </select>
    </div>

    <table class="table table-striped" id="task-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Project</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="task-list">
            @foreach ($tasks as $task)
                <tr data-id="{{ $task->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $task->name }}</td>
                    <td>{{ $task->project ? $task->project->name : 'No Project' }}</td>
                    <td>
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Toast Notification -->
    <div id="toast-container" aria-live="polite" aria-atomic="true" class="position-fixed bottom-0 end-0 p-3">
        <div id="toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Priority Updated</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Task priority has been updated successfully.
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let taskTableBody = document.getElementById('task-list');
            let toastElement = document.getElementById('toast');
            let toast = new bootstrap.Toast(toastElement);

            new Sortable(taskTableBody, {
                onEnd: function (evt) {
                    let tasks = Array.from(taskTableBody.children).map((tr, index) => ({
                        id: tr.dataset.id,
                        priority: index + 1
                    }));

                    fetch('{{ route('tasks.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({tasks: tasks})
                    })
                    .then(response => {
                        if (response.ok) {
                            toast.show();
                        }
                    });
                }
            });

            document.getElementById('project-filter').addEventListener('change', function () {
                let projectId = this.value;
                window.location.href = `{{ route('tasks.index') }}${projectId ? `?project=${projectId}` : ''}`;
            });
        });
    </script>
@endsection
