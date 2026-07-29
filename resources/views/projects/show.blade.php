{{-- resources/views/projects/show.blade.php --}}
{{-- resources/views/projects/show.blade.php --}}
{{-- Versi Fitur 1: cuma tampilkan judul task, styling pakai th-card --}}

@extends('layouts.app')
@section('title', $project->name)
@section('page-title', $project->name)
@section('page-sub', $project->description ?: 'Tidak ada deskripsi')

@section('content')

<div class="th-card">
    <h2 class="text-[15px] font-semibold text-gray-900 mb-5">
        Daftar Tugas
    </h2>

    @forelse($project->tasks as $task)
    <div class="flex items-center gap-3
                        bg-white border border-gray-200
                        rounded-xl px-4 py-3 mb-2">
        <span class="text-sm font-semibold text-gray-900">
            {{ $task->title }}
        </span>
    </div>
    @empty
    <div class="text-center py-12 border-2 border-dashed
                        border-gray-200 rounded-xl">
        <p class="text-sm text-gray-400">
            Belum ada tugas di project ini.
        </p>
    </div>
    @endforelse
</div>

@endsection
{{-- Update Fitur 2: badge prioritas + tombol Tugas Baru --}}

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
    <div class="flex items-center gap-3
                    bg-white border border-gray-200
                    rounded-xl px-4 py-3 mb-2">

        <div class="flex-1 min-w-0">
            <div class="text-sm font-semibold text-gray-900">
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

                @if($task->due_date)
                <span class="text-xs text-gray-400">
                    {{ $task->due_date->format('d M Y') }}
                </span>
                @endif
            </div>
        </div>

    </div>
    @empty
    <div class="text-center py-12 border-2 border-dashed
                    border-gray-200 rounded-xl">
        <p class="text-sm text-gray-400">Belum ada tugas.</p>
    </div>
    @endforelse
</div>
@endsection