@extends('layouts.app')
@section('title', $project['name'])
@section('page-title',$project['name'])
@section('page-sub', $project['description'] ?: 'Tidak ada deskripsi')

@section('content')
    <div class="th-card">
        <h2 class="text-[15px] font-semibold text-gray-900 mb-5">
            Daftar Tugas
        </h2>

        <a href="{{ route('project.task.create', 1) }}">
            Buat Tugas
        </a>

        @forelse($project['tasks'] as $task)
            <div class="flex items-center gap-3 bg-white border border-gray-200 rounded-lx px-4 py-3 mb-2">
                {{ $task->title }}
            </div>
        @empty
            <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-xl">
                Belum ada tugas di project ini
            </div>
        @endforelse
    </div>
@endsection
