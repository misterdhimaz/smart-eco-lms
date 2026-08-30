@extends('layouts.student')
@section('title', 'Ruang Kelas & Tugas | SMART-ECO')

@section('content')
<div class="max-w-7xl mx-auto pb-20 font-sans text-slate-800">

    <div class="relative rounded-[3rem] bg-gradient-to-br from-[#0a2540] via-[#0f4a8a] to-[#047857] p-8 md:p-12 text-white overflow-hidden shadow-2xl mb-12 border-4 border-white/20 gsap-header">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-emerald-400/30 blur-[100px] rounded-full pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10">
            <div class="text-center lg:text-left flex-1">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur-md rounded-xl border border-white/20 text-emerald-300 text-[10px] font-black uppercase tracking-widest mb-4">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> PORTAL KELAS & TUGAS
                </div>
                <h1 class="text-4xl sm:text-5xl font-black tracking-tight mb-3 uppercase leading-tight drop-shadow-md">Tugas & <br><span class="text-emerald-400">Proyek Kolaborasi</span></h1>
                <p class="text-slate-300 font-bold max-w-md mx-auto lg:mx-0 text-sm">Masuk ke ruang kelas digitalmu. Selesaikan tugas, kumpulkan proyek, dan pantau nilaimu secara real-time.</p>
            </div>

            <div class="bg-white/10 backdrop-blur-xl border-2 border-white/30 p-6 sm:p-8 rounded-[2rem] w-full max-w-sm shadow-2xl relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-b from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="text-center mb-5 relative z-10">
                    <h3 class="text-lg font-black text-white uppercase tracking-wider">Gabung Kelas Baru</h3>
                    <p class="text-[10px] text-emerald-200 font-bold uppercase tracking-widest mt-1">Gunakan 5 digit kode unik</p>
                </div>

                <form action="{{ route('student.proyek.join') }}" method="POST" class="space-y-4 relative z-10">
                    @csrf
                    <input type="text" name="code" maxlength="5" required
                           class="w-full text-center text-3xl font-black tracking-[1rem] py-4 bg-white/90 border-2 border-transparent focus:border-emerald-400 rounded-2xl uppercase text-slate-800 outline-none transition-all placeholder:text-slate-300 shadow-inner"
                           placeholder="*****">
                    <button type="submit" class="w-full py-4 bg-emerald-500 hover:bg-emerald-400 text-slate-900 rounded-xl font-black uppercase tracking-widest text-xs transition-transform hover:-translate-y-1 active:scale-95 shadow-[0_10px_20px_rgba(16,185,129,0.3)]">
                        Masuk Kelas 🚀
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center font-black text-xl shadow-sm">🏫</div>
        <h2 class="text-2xl font-black text-slate-800 tracking-tight">Kelas Saya</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($classrooms as $class)
        <a href="{{ route('student.proyek.show', $class->id) }}" class="block group bg-white rounded-[2.5rem] border-2 border-slate-200/80 hover:border-emerald-500 hover:shadow-2xl transition-all duration-500 overflow-hidden gsap-card relative">
            <div class="h-24 bg-gradient-to-r from-slate-800 to-slate-700 relative overflow-hidden group-hover:from-[#0a2540] group-hover:to-[#047857] transition-colors duration-500">
                <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
            </div>

            <div class="p-6 relative">
                <div class="absolute -top-12 left-6 w-16 h-16 bg-white rounded-2xl border-4 border-slate-50 flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-transform">
                    📚
                </div>

                <div class="mt-6">
                    <h3 class="text-xl font-black text-slate-900 uppercase leading-tight group-hover:text-emerald-700 transition-colors">{{ $class->name }}</h3>
                    <p class="text-xs font-bold text-slate-400 mt-1 tracking-wider uppercase">{{ $class->subject ?? 'Umum' }}</p>
                </div>

                <div class="mt-8 pt-5 border-t-2 border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-black text-xs shrink-0">
                            {{ substr($class->admin->name, 0, 1) }}
                        </div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest truncate max-w-[120px]">{{ $class->admin->name }}</p>
                    </div>
                    <span class="bg-slate-100 text-slate-500 px-3 py-1.5 rounded-lg text-[9px] font-black uppercase group-hover:bg-emerald-100 group-hover:text-emerald-700 transition-colors">Lihat Tugas &rarr;</span>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full py-16 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-300 shadow-sm">
            <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center text-5xl mx-auto mb-6 grayscale opacity-60">
                📭
            </div>
            <h3 class="text-2xl font-black text-slate-700 uppercase tracking-tight">Belum Ada Kelas</h3>
            <p class="text-sm font-bold text-slate-400 mt-2 max-w-sm mx-auto">Silakan masukkan 5 digit kode kelas dari Dosen/Pengajar Anda pada kolom di atas untuk mulai belajar.</p>
        </div>
        @endforelse
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        gsap.from(".gsap-header", { y: -20, opacity: 0, duration: 0.6, ease: "power2.out" });
        gsap.from(".gsap-card", { y: 30, opacity: 0, duration: 0.5, stagger: 0.1, ease: "back.out(1.2)" });

        // Jika kode salah atau sudah join
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal Masuk!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#ef4444',
                customClass: { popup: 'rounded-[2rem]', confirmButton: 'rounded-xl px-6 font-bold uppercase tracking-widest' }
            });
        @endif

        // Jika berhasil join
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#10b981',
                customClass: { popup: 'rounded-[2rem]', confirmButton: 'rounded-xl px-6 font-bold uppercase tracking-widest' }
            });
        @endif
    });
</script>
@endsection
