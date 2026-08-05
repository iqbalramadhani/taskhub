<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();

        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:50|unique:tags,name',
            'color' => 'nullable|string|max:7',
        ]);
        $validated['color'] = $validated['color'] ?? '#6D28D9';
        Tag::create($validated);
        return redirect()->route('tags.index')->with('success', 'Tag berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name'  => 'required|string|max:50|unique:tags,name,' . $tag->id,
            'color' => 'nullable|string|max:7',
        ]);
        $tag->update($request->only('name', 'color'));
        return redirect()->route('tags.index')->with('success', 'Tag diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete(); // onDelete cascade hapus semua relasi di pivot
        return redirect()->route('tags.index')->with('success', 'Tag dihapus!');
    }
}
