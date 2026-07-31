{{-- resources/views/projects/show.blade.php -- VERSI FINAL --}}

@extends('layouts.app')
@section('title', $project->name)
@section('page-title', $project->name)
@section('page-sub', $project->description ?: 'Tidak ada deskripsi')

@section('topbar-actions')
<a href="{{ route('projects.tasks.create', $project) }}"
    class="th-btn th-btn-secondary text-sm">
    + Tugas Baru
</a>
@endsection

@section('content')
<div class="th-card">
    <h2 class="text-[15px] font-semibold text-gray-900 mb-5">Daftar Tugas</h2>

    @forelse($project->tasks as $task)

    @php
    $borderColor = $task->is_completed
    ? '#15803D'
    : ($task->isOverdue() ? '#EF4444' : $project->color);
    @endphp

    <div class="flex items-center gap-3
                    bg-white border border-gray-200
                    rounded-xl px-4 py-3 mb-2
                    border-l-4 transition-all hover:shadow-[var(--shadow-sm)]
                    {{ $task->is_completed ? 'opacity-60' : '' }}"
        style="border-left-color: {{ $borderColor }}">

        {{-- Checkbox toggle --}}
        <form action="{{ route('tasks.toggle', $task) }}" method="POST">
            @csrf @method('PATCH')
            <button type="submit"
                class="w-5 h-5 rounded-md border-2 flex items-center
                               justify-content-center text-xs font-bold transition-all
                               {{ $task->is_completed
                                   ? 'bg-green-500 border-green-500 text-white'
                                   : 'border-gray-200 hover:border-green-500 text-transparent' }}">
                v
            </button>
        </form>

        {{-- Konten task --}}
        <div class="flex-1 min-w-0">
            <div class="text-sm font-semibold
                            {{ $task->is_completed
                                ? 'line-through text-gray-400'
                                : 'text-gray-900' }}">
                {{ $task->title }}
            </div>

            <div class="flex items-center gap-2 flex-wrap mt-1">

                {{-- Badge prioritas --}}
                @php
                $pColors = [
                'high' => 'bg-red-50 text-red-500',
                'medium' => 'bg-amber-50 text-amber-700',
                'low' => 'bg-green-50 text-green-600',
                ];
                $pLabels = ['high'=>'Tinggi','medium'=>'Sedang','low'=>'Rendah'];
                @endphp
                <span class="text-xs font-semibold font-mono px-2 py-0.5
                                 rounded-full {{ $pColors[$task->priority] }}">
                    {{ $pLabels[$task->priority] }}
                </span>

                {{-- Due date + badge terlambat --}}
                @if($task->due_date)
                <span class="text-xs flex items-center gap-1
                                     {{ $task->isOverdue()
                                         ? 'text-red-500 font-semibold'
                                         : 'text-gray-400' }}">
                    {{ $task->due_date->format('d M Y') }}
                    @if($task->isOverdue())
                    <span class="font-bold">— Terlambat!</span>
                    @endif
                </span>
                @endif

            </div>
        </div>

        {{-- Aksi --}}
        <div class="flex items-center gap-1 flex-shrink-0">
            <a href="{{ route('projects.tasks.edit', [$project, $task]) }}"
                class="text-xs text-gray-400 hover:text-blue-600
                          px-2.5 py-1 rounded-lg transition-colors">
                Edit
            </a>
            <form action="{{ route('projects.tasks.destroy', [$project, $task]) }}"
                method="POST" onsubmit="return confirm('Hapus tugas ini?')">
                @csrf @method('DELETE')
                <button type="submit"
                    class="text-xs text-gray-400 hover:text-red-500
                                   px-2.5 py-1 rounded-lg transition-colors">
                    Hapus
                </button>
            </form>
        </div>

    </div>

    @empty
    <div class="text-center py-12 border-2 border-dashed
                    border-gray-200 rounded-xl">
        <div class="text-4xl mb-3 opacity-20">✅</div>
        <p class="text-sm text-gray-400 mb-4">
            Belum ada tugas di project ini.
        </p>
        <a href="{{ route('projects.tasks.create', $project) }}"
            class="th-btn th-btn-primary text-sm">
            + Tambah Tugas Pertama
        </a>
    </div>
    @endforelse

</div>
@endsection