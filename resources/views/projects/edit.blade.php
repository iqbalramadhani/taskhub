{{-- resources/views/projects/edit.blade.php --}}
{{-- TIGA PERBEDAAN dari create.blade.php: --}}
{{-- 1. action → projects.update bukan projects.store --}}
{{-- 2. @method('PUT') → wajib untuk method PUT --}}
{{-- 3. value → old('field', $project->field) bukan old('field') saja --}}
@extends('layouts.app')
@section('title', 'Edit — '.$project->name)
@section('page-title', 'Edit Project')
@section('page-sub', $project->name)
@section('content')
<div class="max-w-2xl">
    <form action="{{ route('projects.update', $project) }}" method="POST"
        class="bg-white rounded-2xl border border-[#ECECE9] p-6
space-y-5">
        @csrf
        @method('PUT') {{-- ← WAJIB: beritahu Laravel ini adalah PUT
request --}}
        {{-- Nama Project --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                Nama Project <span class="text-red-500">*</span>
            </label>
            {{-- old('name', $project->name) = pakai old jika ada, fallback
ke data project --}}
            <input type="text" name="name"
                value="{{ old('name', $project->name) }}"
                class="w-full rounded-xl border border-[#ECECE9]
bg-[#FAFAF8]
focus:border-blue-500 focus:ring-2
focus:ring-blue-100
focus:bg-white px-3.5 py-2.5 text-sm
transition-colors
@error('name') border-red-400 bg-red-50
@enderror">
            @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        {{-- Deskripsi --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                Deskripsi <span class="text-gray-400
font-normal">(opsional)</span>
            </label>
            <textarea name="description" rows="3"
                class="w-full rounded-xl border border-[#ECECE9]
bg-[#FAFAF8]
focus:border-blue-500 focus:ring-2
focus:ring-blue-100
focus:bg-white px-3.5 py-2.5 text-sm
transition-colors resize-none">{{
old('description', $project->description) }}</textarea>
        </div>
        {{-- Warna Label --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Warna Label
            </label>
            <div class="flex gap-2 flex-wrap">
                @foreach(['#3B82F6','#10B981','#F59E0B','#EF4444','#8B5CF6','#EC4899','#06B6
                D4','#F97316'] as $c)
                <label class="cursor-pointer">
                    <input type="radio" name="color" value="{{ $c }}"
                        class="sr-only peer"
                        {{ old('color', $project->color) === $c ?
'checked' : '' }}>
                    <div class="w-9 h-9 rounded-full ring-2
ring-offset-2
ring-transparent
peer-checked:ring-gray-500
hover:scale-110 transition-all"
                        style="background-color:{{ $c }}"></div>
                </label>
                @endforeach
            </div>
        </div>
        {{-- Tombol --}}
        <div class="flex gap-3 pt-2">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white
text-sm font-semibold px-5 py-2.5 rounded-xl
transition-colors">
                Simpan Perubahan
            </button>
            <a href="{{ route('projects.show', $project) }}"
                class="text-gray-500 hover:text-gray-900 text-sm
font-medium px-5 py-2.5 transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection