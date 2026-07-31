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

        // untuk validasi
        $validated = $request->validate([
            'title'       => 'required|string|min:3|max:255',
            'description' => 'nullable|string',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'nullable|date|after_or_equal:today',
        ]);

        // dd($validated);

        // simpan task
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
    public function edit(Project $project, Task $task)
    {
        // pengecekan apakah ini task milik user
        abort_if($task->user_id !== auth()->id(), 403);
        return view('tasks.edit', compact('project', 'task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, Task $task)
    {
        // pengecekan apakah ini task milik user
        abort_if($task->user_id !== auth()->id(), 403);

        // validasi data
        $validated = $request->validate([
            'title'       => 'required|string|min:3|max:255',
            'description' => 'nullable|string',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'nullable|date',
        ]);

        // update task
        $task->update($validated);

        return redirect()->route('projects.show', $project)->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);
        // hapus task terkait pada project yang di pilih
        $task->delete();

        return redirect()->route('projects.show', $project)->with('success', 'Tugas berhasil dihapus!');
    }

    public function toggle(Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);
        $task->update(['is_completed' => !$task->is_completed]);
        $msg = $task->is_completed ? 'Tugas ditandai selesai!' : 'Tugas dibuka kembali.';
        return back()->with('success', $msg);
    }
}
