<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskGlobalController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query()
            ->where('user_id', auth()->id())
            // Eager loading — cegah N+1 query
            ->with(['project', 'tags', 'attachments']);

        // === SEARCH: cari berdasarkan judul ===
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // === FILTER: project ===
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // === FILTER: prioritas ===
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // === FILTER: status selesai/belum ===
        if ($request->filled('status')) {
            $query->where('is_completed', $request->status === 'done');
        }

        // === FILTER: berdasarkan tag ===
        if ($request->filled('tag_id')) {
            $query->whereHas(
                'tags',
                fn($q) =>
                $q->where('tags.id', $request->tag_id)
            );
        }

        // === SORTING ===
        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'due_date'      => $query->orderBy('due_date', 'asc'),
            'priority_high' => $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low')"),
            'priority_low'  => $query->orderByRaw("FIELD(priority, 'low', 'medium', 'high')"),
            'oldest'        => $query->oldest(),
            default         => $query->latest(),
        };

        $tasks    = $query->paginate(15);
        $projects = Project::where('user_id', auth()->id())->get();
        $tags     = Tag::all();

        return view('tasks.index', compact('tasks', 'projects', 'tags'));
    }
}
