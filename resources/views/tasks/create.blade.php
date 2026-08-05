{{-- resources/views/tasks/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Tugas Baru -- ' . $project->name)
@section('page-title', 'Tugas Baru')
@section('page-sub', 'Project: ' . $project->name)

@section('topbar-actions')
    <a href="{{ route('projects.show', $project) }}" class="th-btn th-btn-ghost text-sm">
        Batal
    </a>
@endsection

@section('content')
    <div class="max-w-2xl">
        <form action="{{ route('projects.tasks.store', $project) }}" method="POST" class="th-card space-y-5"
            enctype="multipart/form-data">
            @csrf

            {{-- Judul --}}
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                    Judul Tugas <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Apa yang perlu diselesaikan?"
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
                <textarea name="description" rows="3" class="th-textarea">{{ old('description') }}</textarea>
            </div>

            {{-- Prioritas + Tenggat --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                        Prioritas
                    </label>
                    <select name="priority" class="th-select">
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>
                            Rendah
                        </option>
                        <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>
                            Sedang
                        </option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>
                            Tinggi
                        </option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                        Tenggat Waktu
                        <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <input type="date" name="due_date" value="{{ old('due_date') }}" class="th-input">
                    @error('due_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Tambahkan di tasks/create.blade.php DAN tasks/edit.blade.php --}}
            {{-- WAJIB: enctype="multipart/form-data" di tag <form> --}}

            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-1.5">
                    Lampiran
                    <span class="text-gray-400 font-normal">
                        (opsional · jpg, png, pdf, doc, docx · maks 2MB)
                    </span>
                </label>
                <input type="file" name="attachments[]" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                    class="w-full text-sm text-gray-400
                  file:mr-3 file:py-2 file:px-4
                  file:rounded-xl file:border-0
                  file:text-sm file:font-semibold
                  file:bg-blue-100 file:text-blue-600
                  hover:file:bg-blue-50
                  transition-colors cursor-pointer">
                @error('attachments.*')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tambahkan di form tasks/create.blade.php --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tags</label>
                <div class="flex flex-wrap gap-2">
                    @foreach ($tags as $tag)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="sr-only peer"
                                {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                            <span
                                class="inline-block px-3 py-1.5 rounded-full text-xs font-semibold
                            border-2 border-transparent peer-checked:border-current
                            transition-all cursor-pointer"
                                style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}">
                                {{ $tag->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex gap-3 pt-2">
                <button type="submit" class="th-btn th-btn-primary text-sm">
                    Simpan Tugas
                </button>
                <a href="{{ route('projects.show', $project) }}" class="th-btn th-btn-ghost text-sm">
                    Batal
                </a>
            </div>

        </form>
    </div>
@endsection
