{{-- resources/views/tasks/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Semua Tugas')
@section('content')
 
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Semua Tugas</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $tasks->total() }} tugas ditemukan</p>
    </div>
</div>
 
{{-- Toolbar Search + Filter + Sort --}}
<form method="GET" action="{{ route('tasks.index') }}"
      class="bg-white rounded-2xl border border-gray-200 p-4 mb-6">
    <div class="flex flex-wrap gap-3">
 
        {{-- Search --}}
        <div class="flex-1 min-w-52">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari judul tugas..."
                   class="w-full rounded-lg border-gray-300 focus:border-purple-500 text-sm">
        </div>
 
        {{-- Filter Project --}}
        <select name="project_id" class="rounded-lg border-gray-300 text-sm">
            <option value="">Semua Project</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}" {{ request('project_id')==$project->id ? 'selected' : '' }}>
                    {{ $project->name }}
                </option>
            @endforeach
        </select>
 
        {{-- Filter Prioritas --}}
        <select name="priority" class="rounded-lg border-gray-300 text-sm">
            <option value="">Semua Prioritas</option>
            <option value='high'   {{ request('priority')=='high'   ? 'selected':'' }}>Tinggi</option>
            <option value='medium' {{ request('priority')=='medium' ? 'selected':'' }}>Sedang</option>
            <option value='low'    {{ request('priority')=='low'    ? 'selected':'' }}>Rendah</option>
        </select>
 
        {{-- Filter Status --}}
        <select name="status" class="rounded-lg border-gray-300 text-sm">
            <option value="">Semua Status</option>
            <option value='todo' {{ request('status')=='todo' ? 'selected':'' }}>Belum Selesai</option>
            <option value='done' {{ request('status')=='done' ? 'selected':'' }}>Selesai</option>
        </select>
 
        {{-- Filter Tag --}}
        <select name="tag_id" class="rounded-lg border-gray-300 text-sm">
            <option value="">Semua Tag</option>
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}" {{ request('tag_id')==$tag->id ? 'selected' : '' }}>
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>
 
        {{-- Sorting --}}
        <select name="sort" class="rounded-lg border-gray-300 text-sm">
            <option value='latest'       {{ request('sort','latest')=='latest'       ? 'selected':'' }}>Terbaru</option>
            <option value='due_date'     {{ request('sort')=='due_date'              ? 'selected':'' }}>Tenggat Terdekat</option>
            <option value='priority_high'{{ request('sort')=='priority_high'        ? 'selected':'' }}>Prioritas Tertinggi</option>
        </select>
 
        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium px-4 py-2 rounded-lg">
            Cari
        </button>
        <a href="{{ route('tasks.index') }}" class="text-sm text-gray-500 hover:text-gray-900 py-2">
            Reset
        </a>
    </div>
</form>
 
{{-- Daftar Task --}}
<div class="space-y-2">
    @forelse($tasks as $task)
        <div class="bg-white border border-gray-200 rounded-xl px-4 py-3
                    border-l-4 flex items-center gap-3 hover:shadow-sm transition-shadow"
             style="border-left-color: {{ $task->project->color }}">
 
            {{-- Checkbox (toggle) --}}
            <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit"
                        class="w-5 h-5 rounded-md border-2 flex items-center justify-center
                               {{ $task->is_completed ? 'bg-green-500 border-green-500 text-white' : 'border-gray-300 hover:border-green-400' }}">
                    @if($task->is_completed) ✓ @endif
                </button>
            </form>
 
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-semibold {{ $task->is_completed ? 'line-through text-gray-400' : 'text-gray-900' }}">
                        {{ $task->title }}
                    </span>
                </div>
                <div class="flex items-center gap-2 mt-1 flex-wrap">
                    <span class="text-xs text-gray-400">{{ $task->project->name }}</span>
                    @foreach($task->tags as $tag)
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full"
                              style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
 
            <div class="flex items-center gap-3 flex-shrink-0">
                @if($task->due_date)
                    <span class="text-xs {{ $task->isOverdue() ? 'text-red-500 font-semibold' : 'text-gray-400' }}">
                        ⏰ {{ $task->due_date->format('d M') }}
                    </span>
                @endif
                @if($task->attachments->count())
                    <span class="text-xs text-gray-400">📎 {{ $task->attachments->count() }}</span>
                @endif
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl border border-dashed border-gray-300 p-12 text-center">
            <p class="text-sm text-gray-400">Tidak ada tugas yang sesuai filter.</p>
        </div>
    @endforelse
</div>
 
{{-- Pagination --}}
<div class="mt-6">
    {{ $tasks->links() }}
</div>
@endsection