@extends('layouts.student')
@section('title', 'Kelas: ' . $classroom->name)

@section('content')
<div class="max-w-5xl mx-auto pb-20 font-sans text-slate-800">

    <a href="{{ route('student.proyek') }}" class="inline-flex items-center gap-2 text-xs font-black text-slate-500 hover:text-emerald-600 transition-colors mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Kelas
    </a>

    <div class="relative rounded-[2.5rem] bg-slate-900 p-8 md:p-12 text-white overflow-hidden shadow-xl mb-10 border-4 border-white">
        <div class="absolute inset-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/80 to-transparent"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-end justify-between gap-6 h-full pt-16">
            <div>
                <h1 class="text-4xl sm:text-5xl font-black tracking-tight mb-2 uppercase drop-shadow-lg">{{ $classroom->name }}</h1>
                <p class="text-emerald-400 font-black tracking-widest text-xs uppercase">{{ $classroom->subject ?? 'Kelas Umum' }}</p>
            </div>
            <div class="bg-white/20 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/30 text-center shrink-0">
                <p class="text-[9px] font-black uppercase tracking-widest text-slate-300 mb-1">Pengajar</p>
                <p class="text-sm font-bold text-white">{{ $classroom->admin->name }}</p>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3 mb-6">
        <div class="w-8 h-8 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center font-black shadow-sm">📋</div>
        <h2 class="text-xl font-black text-slate-800 tracking-tight uppercase">Daftar Tugas & Proyek</h2>
    </div>

    <div class="space-y-4">
        @forelse($classroom->assignments as $assignment)
            @php
                // Cek status pengumpulan tugas user ini
                $submission = $assignment->submissions()->where('user_id', Auth::id())->first();
                $isDone = $submission && $submission->status !== 'late';
                $isGraded = $submission && $submission->grade !== null;
            @endphp

            <a href="{{ route('student.proyek.assignment', $assignment->id) }}" class="flex flex-col sm:flex-row items-start sm:items-center gap-6 p-6 bg-white rounded-3xl border-2 border-slate-200/80 hover:border-emerald-500 hover:shadow-lg transition-all group">

                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 shadow-inner {{ $isDone ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                    {{ $isDone ? '✅' : '📝' }}
                </div>

                <div class="flex-1">
                    <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight group-hover:text-emerald-700 transition-colors">{{ $assignment->title }}</h3>
                    <p class="text-[11px] font-bold text-slate-500 mt-1 flex items-center gap-2">
                        <span>Diposting: {{ $assignment->created_at->format('d M') }}</span>
                        @if($assignment->due_date)
                            <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                            <span class="text-rose-500">Tenggat: {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M, H:i') }}</span>
                        @endif
                    </p>
                </div>

                <div class="shrink-0 flex items-center gap-3 w-full sm:w-auto mt-4 sm:mt-0">
                    @if($isGraded)
                        <span class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest text-center">
                            Nilai: {{ $submission->grade }}/100
                        </span>
                    @elseif($isDone)
                        <span class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest">
                            Diserahkan
                        </span>
                    @else
                        <span class="bg-slate-100 border border-slate-200 text-slate-600 group-hover:bg-emerald-600 group-hover:border-emerald-600 group-hover:text-white px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-colors shadow-sm">
                            Kerjakan Tugas
                        </span>
                    @endif
                </div>
            </a>
        @empty
            <div class="py-16 text-center bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-200">
                <span class="text-5xl block mb-4 grayscale opacity-40">🎉</span>
                <h3 class="text-lg font-black text-slate-500 uppercase tracking-widest">Hore! Belum Ada Tugas.</h3>
                <p class="text-xs font-bold text-slate-400 mt-1">Dosen/Pengajar Anda belum menambahkan tugas di kelas ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
