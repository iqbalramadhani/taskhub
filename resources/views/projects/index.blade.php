{{-- resources/views/projects/index.blade.php --}}
{{-- Langkah 1: Extends layout + set judul + tombol aksi di topbar --}}
@extends('layouts.app')
@section('title', 'Project Saya')
@section('page-title', 'Project Saya')
@section('page-sub', $projects->count() . ' project aktif')
@section('topbar-actions')
    <a href="{{ route('projects.create') }}"
        class="inline-flex items-center gap-2 bg-[#FF6B4A] hover:bg-[#FF5733] text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
        </svg>
        Project Baru
    </a>
@endsection
{{-- Langkah 2: Section content — buka @section, tulis empty state dulu --}}
@section('content')
    @if ($projects->isEmpty())
        {{-- Empty state: muncul kalau belum ada project sama sekali --}}
        <div class="bg-white border-2 border-dashed border-[#ECECE9] rounded-2xl p-16 text-center">
            <div class="text-5xl mb-4 opacity-30">📁</div>
            <h3 class="text-lg font-bold text-gray-700 mb-2">
                Belum ada project
            </h3>
            <p class="text-sm text-gray-400 mb-6">
                Buat project pertama untuk mulai mengorganisir tugas kamu.
            </p>
            <a href="{{ route('projects.create') }}"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                + Buat Project Pertama
            </a>
        </div>
    @else
        {{-- Langkah 3: Grid kartu project (muncul kalau ada data) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($projects as $project)
                <a href="{{ route('projects.show', $project) }}"
                    class="bg-white rounded-2xl border border-[#ECECE9] p-5 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 block relative overflow-hidden group">
                    {{-- Strip warna di atas kartu --}}
                    <div class="absolute top-0 left-0 right-0 h-[3px]" style="background-color:{{ $project->color }}"></div>
                    {{-- Nama project + dot warna --}}
                    <div class="flex items-center gap-2 mb-2 mt-1">
                        <span class="w-[10px] h-[10px] rounded-full shrink-0"
                            style="background-color:{{ $project->color }}"></span>
                        <h3 class="font-bold text-gray-900 truncate text-[15px] group-hover:text-blue-600 transition-colors">
                            {{ $project->name }}
                        </h3>
                    </div>
                    {{-- Deskripsi — line-clamp-2 = max 2 baris --}}
                    <p class="text-sm text-gray-400 line-clamp-2 mb-4 min-h-[40px]">
                        {{ $project->description ?: 'Tidak ada deskripsi' }}
                    </p>
                    {{-- Footer kartu: counter task + tombol edit/hapus --}}
                    <div class="flex items-center justify-between pt-3 border-t border-[#ECECE9]">
                        <span class="text-xs text-gray-400">
                            📋 {{ $project->tasks_count }} tugas
                        </span>
                        {{-- onclick stopPropagation agar klik tombol tidak membuka halaman detail project --}}
                        <div class="flex gap-1" onclick="event.stopPropagation()">
                            <a href="{{ route('projects.edit', $project) }}"
                                class="text-xs text-gray-400 hover:text-blue-600 px-2.5 py-1 rounded-lg transition-colors">
                                Edit
                            </a>
                            <form action="{{ route('projects.destroy', $project) }}" method="POST"
                                onsubmit="return confirm('Hapus project ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-xs text-gray-400 hover:text-red-600 px-2.5 py-1 rounded-lg transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </a>
            @endforeach
            {{-- Kartu khusus: tombol tambah project baru --}}
            <a href="{{ route('projects.create') }}"
                class="bg-white border-2 border-dashed border-[#ECECE9] rounded-2xl flex flex-col items-center justify-center gap-3 min-h-[180px] hover:border-[#FF6B4A] hover:text-[#FF6B4A] hover:bg-[#FFF7F5] text-gray-300 transition-all">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                <span class="text-sm font-semibold">Project Baru</span>
            </a>
        </div>
    @endif
    {{-- tutup @if ($projects->isEmpty()) --}}
@endsection
{{-- tutup @section('content') --}}
