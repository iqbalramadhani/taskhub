{{-- resources/views/tasks/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Tugas Baru -- '.$project->name)
@section('page-title', 'Tugas Baru')
@section('page-sub', 'Project: '.$project->name)

@section('topbar-actions')
<a href="{{ route('projects.show', $project) }}"
    class="th-btn th-btn-ghost text-sm">
    Batal
</a>
@endsection

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('projects.tasks.store', $project) }}" method="POST"
        class="th-card space-y-5">
        @csrf

        {{-- Judul --}}
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                Judul Tugas <span class="text-red-500">*</span>
            </label>
            <input type="text" name="title" value="{{ old('title') }}"
                placeholder="Apa yang perlu diselesaikan?"
                class="th-input @error('title') error @enderror">
            @error('title')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                Deskripsi
                <span class="text-gray-400 font-normal">(opsional)</span>
            </label>
            <textarea name="description" rows="3"
                class="th-textarea">{{ old('description') }}</textarea>
        </div>

        {{-- Prioritas + Tenggat --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                    Prioritas
                </label>
                <select name="priority" class="th-select">
                    <option value="low"
                        {{ old('priority') == 'low' ? 'selected' : '' }}>
                        Rendah
                    </option>
                    <option value="medium"
                        {{ old('priority','medium') == 'medium' ? 'selected' : '' }}>
                        Sedang
                    </option>
                    <option value="high"
                        {{ old('priority') == 'high' ? 'selected' : '' }}>
                        Tinggi
                    </option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                    Tenggat Waktu
                    <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <input type="date" name="due_date" value="{{ old('due_date') }}"
                    class="th-input">
                @error('due_date')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Tombol --}}
        <div class="flex gap-3 pt-2">
            <button type="submit" class="th-btn th-btn-primary text-sm">
                Simpan Tugas
            </button>
            <a href="{{ route('projects.show', $project) }}"
                class="th-btn th-btn-ghost text-sm">
                Batal
            </a>
        </div>

    </form>
</div>
@endsection