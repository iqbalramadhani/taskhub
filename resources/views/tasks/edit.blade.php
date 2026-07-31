{{-- resources/views/tasks/edit.blade.php --}}
{{-- 3 PERBEDAAN dari create: action update, @method(PUT), value dari $task --}}

@extends('layouts.app')
@section('title', 'Edit -- ' . $task->title)
@section('page-title', 'Edit Tugas')
@section('page-sub', $task->title)

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('projects.tasks.update', [$project, $task]) }}" method="POST" class="th-card space-y-5">
        @csrf
        @method('PUT')
 
        {{-- Judul --}}
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                Judul Tugas <span class="text-red-500">*</span>
            </label>
            <input type="text" name="title" value="{{ old('title', $task->title) }}" class="th-input @error('title') error @enderror">
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
 
        {{-- Deskripsi --}}
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                Deskripsi
            </label>
            <textarea name="description" rows="3" class="th-textarea">{{ old('description', $task->description) }}</textarea>
        </div>
 
        {{-- Prioritas + Tenggat --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                    Prioritas
                </label>
                <select name="priority" class="th-select">
                    <option value="low"
                        {{ old('priority',$task->priority) == 'low' ? 'selected' : '' }}>
                        Rendah
                    </option>
                    <option value="medium"
                        {{ old('priority',$task->priority) == 'medium' ? 'selected' : '' }}>
                        Sedang
                    </option>
                    <option value="high"
                        {{ old('priority',$task->priority) == 'high' ? 'selected' : '' }}>
                        Tinggi
                    </option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                    Tenggat Waktu
                </label>
                <input type="date" name="due_date"
                       value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                       class="th-input">
            </div>
        </div>
 
        {{-- Tombol --}}
        <div class="flex gap-3 pt-2">
            <button type="submit" class="th-btn th-btn-primary text-sm">
                Simpan Perubahan
            </button>
            <a href="{{ route('projects.show', $project) }}"
               class="th-btn th-btn-ghost text-sm">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection