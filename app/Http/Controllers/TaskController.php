<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [];
        // $project = [];
        $project = [];
        $task = Task::all();

        $project['name'] = 'Project Tes';
        $project['description'] = 'Deskripsi Project Buat Di Tes';
        $project['tasks'] = $task;

        return view('projects.show', compact('data', 'project'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        abort_if($project->user_id !== auth()->id(), 403);
        return view('tasks.create', compact('project'));
    }

    /**
     * 
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        abort_if($project->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'title'       => 'required|string|min:3|max:255',
            'description' => 'nullable|string',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'nullable|date|after_or_equal:today',
        ]);

        $project->tasks()->create([
            'user_id'      => auth()->id(),
            'title'        => $validated['title'],
            'description'  => $validated['description'] ?? null,
            'priority'     => $validated['priority'],
            'due_date'     => $validated['due_date'] ?? null,
            'is_completed' => false,
        ]);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Tugas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
