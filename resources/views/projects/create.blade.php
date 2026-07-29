{{-- resources/views/projects/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Project Baru')
@section('page-title', 'Project Baru')
@section('page-sub', 'Isi detail project yang akan kamu kerjakan')
@section('content')
<div class="max-w-2xl">
    <form action="{{ route('projects.store') }}" method="POST"
        class="bg-white rounded-2xl border border-[#ECECE9] p-6 space-y-5">
        @csrf {{-- WAJIB ada di setiap form POST agar tidak error 419 --}}
        {{-- Field 1: Nama Project --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                Nama Project <span class="text-red-500">*</span>
            </label>
            {{-- old('name') = isi ulang nilai jika validasi gagal --}}
            <input type="text" name="name" value="{{ old('name') }}"
                placeholder="Contoh: Website Redesign"
                class="w-full rounded-xl border border-[#ECECE9]
bg-[#FAFAF8]
focus:border-blue-500 focus:ring-2
focus:ring-blue-100
focus:bg-white px-3.5 py-2.5 text-sm
transition-colors
@error('name') border-red-400 bg-red-50
@enderror">
            {{-- @error = tampilkan pesan error validasi untuk field 'name'
--}}
            @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        {{-- Field 2: Deskripsi --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                Deskripsi
                <span class="text-gray-400 font-normal">(opsional)</span>
            </label>
            <textarea name="description" rows="3"
                placeholder="Deskripsi singkat project ini..."
                class="w-full rounded-xl border border-[#ECECE9]
bg-[#FAFAF8]
focus:border-blue-500 focus:ring-2
focus:ring-blue-100
focus:bg-white px-3.5 py-2.5 text-sm
transition-colors resize-none">{{
old('description') }}</textarea>
        </div>
        {{-- Field 3: Warna Label (radio button visual) --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Warna Label
            </label>
            <div class="flex gap-2 flex-wrap">
                @foreach(['#3B82F6','#10B981','#F59E0B','#EF4444','#8B5CF6','#EC4899','#06B6
                D4','#F97316'] as $c)
                <label class="cursor-pointer">
                    {{-- sr-only = radio tersembunyi, tampilan diganti div bulat --}}
                    <input type="radio" name="color" value="{{ $c }}"
                        class="sr-only peer"
                        {{ old('color', '#3B82F6') === $c ? 'checked' : '' }}>
                    {{-- peer-checked = lingkaran ring aktif saat radio checked --}}
                    <div class="w-9 h-9 rounded-full
ring-2 ring-offset-2 ring-transparent
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
                Simpan Project
            </button>
            <a href="{{ route('projects.index') }}"
                class="text-gray-500 hover:text-gray-900 text-sm
font-medium px-5 py-2.5 transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection