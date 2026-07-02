@extends('layouts.admin')

@php($topbarTitle = $title ?? 'Segera Hadir')

@section('title', $title ?? 'Segera Hadir')

@section('content')

    <div class="bg-white rounded-2xl p-10 shadow-sm flex flex-col items-center justify-center text-center min-h-[60vh]">
        <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-500 mb-5">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <rect x="4" y="5" width="16" height="16" rx="2"/>
                <path stroke-linecap="round" d="M8 3v4M16 3v4M4 10h16"/>
            </svg>
        </div>
        <h2 class="text-lg font-bold text-slate-800">{{ $title ?? 'Halaman Ini' }}</h2>
        <p class="text-slate-500 text-sm mt-2 max-w-sm">
            Halaman ini sedang dalam proses pengerjaan UI. Akan segera dilanjutkan.
        </p>
    </div>

@endsection