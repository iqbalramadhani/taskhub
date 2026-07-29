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

        return view('projects.show',compact('data','project'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = Project::findOrFail(1);
        return view('task.show', compact('project'));
    }

    /**
     * 
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $title = $request->title;
        $description = $request->description;

        $task = new Task();
        $task->title = $title;
        $task->description = $description;
        $task->project_id = 1;
        $task->user_id = 1;
        $task->save();

        return redirect()->route('tasks.index');
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
