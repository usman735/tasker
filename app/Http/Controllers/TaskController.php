<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $projects = Project::with('tasks')->get();
        $tasks = Task::orderBy('priority')->with('project')->get();
        return view('tasks.index', compact('tasks', 'projects'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('tasks.create', compact('projects'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'project_id' => 'required'
        ]);

        $priority = Task::max('priority') + 1;
        $task =new Task();
        $task->name = $request->name;
        $task->priority = $priority;
        $task->project_id = $request->project_id;
        $task->save();
        return redirect()->route('tasks.index');
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        return view('tasks.edit', compact('task', 'projects'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required',
            'project_id' => 'required'
        ]);

        $task->update([
            'name' => $request->name,
            'project_id' => $request->project_id
        ]);

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }

    public function reorder(Request $request)
    {
        $tasks = $request->tasks;
        foreach ($tasks as $priority => $id) {
            Task::where('id', $id)->update(['priority' => $priority]);
        }
        return response()->json(['status' => 'success']);
    }
}
