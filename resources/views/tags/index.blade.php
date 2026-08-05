{{-- resources/views/tags/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Kelola Tags')
@section('content')
 
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Tags</h1>
    <button onclick="document.getElementById('form-add-tag').classList.toggle('hidden')"
            class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg">
        + Tag Baru
    </button>
</div>
 
{{-- Form tambah tag (toggle) --}}
<div id="form-add-tag" class="hidden bg-white rounded-2xl border border-gray-200 p-5 mb-6">
    <form action="{{ route('tags.store') }}" method="POST" class="flex items-end gap-4">
        @csrf
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Tag</label>
            <input type="text" name="name" placeholder="contoh: urgent, design, bug"
                   class="w-full rounded-lg border-gray-300 focus:border-purple-500 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Warna</label>
            <input type="color" name="color" value="#6D28D9" class="h-10 w-16 rounded-lg border-gray-300 cursor-pointer">
        </div>
        <button type="submit" class="bg-purple-600 text-white text-sm font-medium px-4 py-2.5 rounded-lg">
            Simpan
        </button>
    </form>
</div>
 
{{-- Grid tag --}}
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @forelse($tags as $tag)
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg flex-shrink-0"
                 style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}">
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-semibold text-sm truncate"
                     style="color: {{ $tag->color }}">{{ $tag->name }}</div>
                <div class="text-xs text-gray-400">{{ $tag->tasks_count }} tugas</div>
            </div>
            <form action="{{ route('tags.destroy', $tag) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="text-gray-300 hover:text-red-500 text-xs">✕</button>
            </form>
        </div>
    @empty
        <div class="col-span-4 bg-white rounded-xl border border-dashed border-gray-300 p-10 text-center">
            <p class="text-sm text-gray-400">Belum ada tag. Buat tag pertama!</p>
        </div>
    @endforelse
</div>
@endsection