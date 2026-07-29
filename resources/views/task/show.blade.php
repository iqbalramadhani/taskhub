@extends('layouts.app')
@section('title', 'Tugas Baru --'.$project->name)
@section('page-title','Tugas Baru')
@section('page-sub', 'Project : '.$project->name)


@section('content')
    <div class="max-w-2xl">
        <form action="{{ route('project.task.store', $project) }}" method="POST" class="th-card space-y-5">
            @csrf
            {{-- Judul --}}
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                    Judul Tugas <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Apa yang perlu diselesaikan ?" class="th-input @error('title') error @enderror">
                @error('title')
                <div class="text-red-500 text-xs mt-1">
                    {{ $message }}
                </div>
                @enderror   
            </div>
            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                    Description <span class="text-red-500">*</span>
                </label>
                <input type="text" name="description" value="{{ old('description') }}" placeholder="Apa yang perlu diselesaikan ?" class="th-input @error('description') error @enderror">
                @error('description')
                <div class="text-red-500 text-xs mt-1">
                    {{ $message }}
                </div>
                @enderror   
            </div>


            <div clas="flex gap-3 pt-2">
                <button type="submit" class="th-btn th btn-primary text-sm">Simpan Tugas</button>
                <a href="{{ route('tasks.index')}} "class="th-btn">Batal</a>

            </div>
        </form>
    </div>
@endsection