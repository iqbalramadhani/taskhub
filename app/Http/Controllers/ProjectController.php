<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::where('user_id', auth()->id())
            // withCount('tasks') = hitung jumlah task per project dalam 1 query
            // Hasilnya bisa diakses sebagai $project->tasks_count di view
            ->withCount('tasks')
            ->latest() // urutkan terbaru di atas
            ->get();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tidak ada data yang perlu dikirim ke view
        // Form kosong cukup dengan return view saja
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input — gagal = redirect balik ke form dengan error
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
        ]);
        // 2. Tambahkan user_id (tidak boleh dari form, harus dari server)
        $validated['user_id'] = auth()->id();
        $validated['color'] = $validated['color'] ?? '#3B82F6';
        // 3. Simpan ke database
        Project::create($validated);
        // 4. Redirect ke daftar project dengan flash message
        return redirect()->route('projects.index')->with('success', 'Project berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        // Proteksi kepemilikan — 403 Forbidden kalau bukan miliknya
        abort_if($project->user_id !== auth()->id(), 403);
        // Load relasi tasks (akan ditampilkan di view)
        $project->load('tasks');
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        abort_if($project->user_id !== auth()->id(), 403);
        // Kirim $project ke view agar form bisa pre-filled
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        abort_if($project->user_id !== auth()->id(), 403);
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
        ]);
        $project->update($validated);
        return redirect()->route('projects.show', $project)
            ->with('success', 'Project berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        abort_if($project->user_id !== auth()->id(), 403);
        // delete() otomatis cascade hapus semua tasks milik project ini
        // karena kita set onDelete('cascade') di migration
        $project->delete();
        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil dihapus!');
    }
}
