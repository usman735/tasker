@extends('layouts.app')

@section('content')
    <h1>Projects</h1>
    <a href="{{ route('projects.create') }}" class="btn btn-primary">Create Project</a>
    <ul>
        @foreach ($projects as $project)
            <li>{{ $project->name }}
                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
