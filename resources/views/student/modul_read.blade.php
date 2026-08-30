<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Membaca Materi | SMART-ECO Reader</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- PDF.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';</script>

    <!-- Animasi & SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #475569; }
    </style>
</head>
<body class="bg-[#0f172a] text-slate-300 h-[100dvh] overflow-hidden flex flex-col relative selection:bg-[#10b981] selection:text-white">

    <!-- EFEK BACKGROUND -->
    <div class="absolute inset-0 pointer-events-none z-0">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#1e293b_1px,transparent_1px),linear-gradient(to_bottom,#1e293b_1px,transparent_1px)] bg-[size:4rem_4rem] opacity-30"></div>
        <div class="absolute top-1/4 right-0 md:right-1/4 w-64 md:w-[500px] h-64 md:h-[500px] bg-[#10b981]/5 rounded-full blur-[80px] md:blur-[120px]"></div>
        <div class="absolute bottom-1/4 left-0 md:left-1/4 w-64 md:w-[500px] h-64 md:h-[500px] bg-blue-500/5 rounded-full blur-[80px] md:blur-[120px]"></div>
    </div>

    <!-- HEADER & KONTROL PDF -->
    <header class="h-14 md:h-16 bg-[#111827]/95 backdrop-blur-md border-b border-slate-800 flex items-center justify-between px-3 md:px-6 shrink-0 z-50 shadow-xl select-none relative">

        <div class="flex items-center gap-2 md:gap-4 w-auto md:w-1/3 overflow-hidden shrink-0">
            <span class="bg-[#10b981] text-white px-2 py-1 md:px-3 md:py-1.5 rounded-lg text-[9px] md:text-[10px] font-black tracking-widest flex items-center gap-1.5 md:gap-2 shadow-[0_0_15px_rgba(16,185,129,0.3)] shrink-0 cursor-default">
                <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span class="hidden sm:inline">SMART-ECO READER</span>
                <span class="sm:hidden">READER</span>
            </span>
            <div class="h-6 w-px bg-slate-700 hidden lg:block shrink-0"></div>
            <h3 class="text-white font-bold text-xs truncate hidden lg:block">{{ $module->title }}.pdf</h3>
        </div>

        <div class="flex flex-1 md:flex-none items-center justify-center gap-2 md:gap-6">
            <div class="flex items-center bg-[#1e293b] rounded-lg px-2 py-1 md:py-1.5 border border-slate-700/50 shadow-inner">
                <input type="number" id="pageNumberInput" class="bg-transparent text-white text-center text-[10px] md:text-xs font-bold w-8 md:w-10 outline-none" value="1" min="1">
                <span class="text-[10px] md:text-xs text-slate-500 mx-1 font-bold">/</span>
                <span id="pageCountDisplay" class="text-[10px] md:text-xs text-slate-400 font-bold w-6">0</span>
            </div>

            <div class="flex items-center gap-1 md:gap-1.5">
                <button onclick="zoomOut()" class="p-1 md:p-1.5 text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-colors" title="Perkecil"><svg class="w-4 h-4 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg></button>
                <span id="zoomDisplay" class="font-mono text-[9px] md:text-[10px] font-black text-slate-300 w-8 md:w-10 text-center">100%</span>
                <button onclick="zoomIn()" class="p-1 md:p-1.5 text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-colors" title="Perbesar"><svg class="w-4 h-4 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg></button>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2 w-auto md:w-1/3 shrink-0">
            @if($module->document_file)
                <a href="{{ asset('storage/' . $module->document_file) }}" download="{{ $module->title }}.pdf" class="text-slate-400 hover:text-[#10b981] hover:bg-slate-800 p-1.5 md:p-2 rounded-xl transition-all hidden md:flex items-center gap-2" title="Unduh PDF">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <span class="text-[9px] md:text-[10px] font-bold uppercase tracking-widest hidden lg:inline">Unduh</span>
                </a>
            @endif

            <button onclick="printPDF()" class="text-slate-400 hover:text-white hover:bg-slate-800 p-1.5 md:p-2 rounded-xl transition-all hidden sm:flex items-center gap-2" title="Cetak Modul">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span class="text-[9px] md:text-[10px] font-bold uppercase tracking-widest hidden lg:inline">Cetak</span>
            </button>

            <div class="w-px h-5 md:h-6 bg-slate-700 hidden sm:block mx-1 md:mx-2"></div>

            <a href="{{ route('student.modul') }}" class="w-7 h-7 md:w-9 md:h-9 lg:w-10 lg:h-10 flex items-center justify-center bg-[#1e293b] text-slate-400 hover:text-white hover:bg-rose-500 rounded-lg transition-all border border-slate-700 hover:border-rose-500" title="Tutup Reader">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </a>
        </div>
    </header>

    <!-- AREA KONTEN SCROLL -->
    <div class="flex-1 overflow-y-auto custom-scrollbar relative z-10 w-full" id="pdfScrollArea">
        <div class="w-full max-w-[1000px] mx-auto py-6 md:py-10 px-4 md:px-6 flex flex-col items-center">

            <!-- COVER MODULE -->
            <div class="w-full bg-[#1e293b]/70 backdrop-blur-xl border border-slate-700/50 rounded-2xl md:rounded-3xl p-5 md:p-10 mb-8 md:mb-12 shadow-2xl flex flex-col sm:flex-row gap-6 md:gap-8 items-center sm:items-start relative overflow-hidden gsap-fade">
                <div class="absolute right-4 bottom-2 md:right-8 md:bottom-6 text-slate-700/30 font-serif text-5xl md:text-7xl font-black italic select-none pointer-events-none">E=mc&sup2;</div>

                <div class="w-32 sm:w-40 md:w-56 aspect-[3/4] bg-white rounded-xl overflow-hidden shadow-[0_0_30px_rgba(0,0,0,0.3)] shrink-0 relative p-1.5 z-10">
                    @if($module->cover_image)
                        <img src="{{ asset('storage/' . $module->cover_image) }}" alt="Cover" class="w-full h-full object-cover rounded-lg border border-slate-100">
                    @else
                        <div class="flex flex-col items-center justify-center p-4 text-center w-full h-full bg-slate-100 rounded-lg border border-slate-200">
                            <svg class="w-8 h-8 md:w-12 md:h-12 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <span class="text-slate-400 font-bold text-[8px] md:text-[10px] uppercase tracking-widest">SMART-ECO</span>
                        </div>
                    @endif
                </div>

                <div class="flex-1 text-center sm:text-left relative z-10 w-full pt-2">
                    <span class="inline-block bg-[#10b981]/20 text-emerald-400 px-3 py-1 md:px-4 md:py-1.5 rounded-full text-[9px] md:text-[10px] font-black uppercase tracking-widest mb-3 md:mb-5">{{ $module->category ?? 'Materi Pembelajaran' }}</span>
                    <h1 class="text-2xl md:text-4xl lg:text-5xl font-black text-white mb-4 md:mb-6 leading-tight">{{ $module->title }}</h1>
                    <div class="w-12 md:w-16 h-1 md:h-1.5 bg-[#10b981] rounded-full mx-auto sm:mx-0 mb-6 md:mb-8"></div>
                    <div class="bg-[#0f172a]/60 p-4 md:p-5 rounded-xl md:rounded-2xl border border-slate-700/50 relative text-left">
                        <h4 class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Deskripsi Materi</h4>
                        <p class="text-slate-300 text-xs md:text-sm leading-relaxed font-medium">
                            {{ $module->description ?? 'Materi ini dirancang khusus untuk meningkatkan pemahaman Anda. Pelajari dokumen PDF di bawah ini dengan saksama.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- CONTAINER HALAMAN PDF -->
            <div id="pdfPagesContainer" class="w-full flex flex-col items-center gap-4 md:gap-8 mb-10 md:mb-16"></div>

            <!-- LOADING INDICATOR -->
            <div id="pdfLoading" class="text-white flex flex-col items-center justify-center py-16 md:py-20 w-full gsap-fade">
                <svg class="w-10 h-10 md:w-12 md:h-12 animate-spin mb-3 md:mb-4 text-[#10b981]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                <span class="font-bold tracking-widest text-[10px] md:text-xs uppercase text-slate-400">Menyiapkan Dokumen PDF...</span>
            </div>

            <!-- JIKA PDF KOSONG -->
            <div id="previewPdfFallback" class="w-full max-w-2xl bg-[#1e293b]/80 backdrop-blur-md border border-slate-700 shadow-2xl rounded-2xl md:rounded-3xl p-8 md:p-16 text-center text-slate-400 flex flex-col items-center hidden">
                <svg class="w-12 h-12 md:w-16 md:h-16 mb-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <p class="font-black text-white text-xl md:text-2xl mb-2">Dokumen Belum Tersedia</p>
                <p class="text-xs md:text-sm">Silakan hubungi pengajar, atau Anda bisa langsung mengerjakan Misi Evaluasi (jika tersedia).</p>
            </div>

            <!-- FOOTER AKSI / KUIS -->
            <div class="w-full max-w-3xl bg-gradient-to-r from-[#1e293b] to-[#0f172a] border border-slate-700 shadow-[0_0_50px_rgba(16,185,129,0.05)] rounded-2xl md:rounded-[2rem] p-6 md:p-8 mb-12 flex flex-col sm:flex-row items-center justify-between gap-4 md:gap-6 gsap-fade relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 md:w-2 bg-[#10b981]"></div>

                <div class="text-center sm:text-left flex-1 pl-2 md:pl-4 w-full">
                    <h4 class="text-lg md:text-xl font-black text-white">Selesai Membaca?</h4>
                    @if($assessment)
                        <p class="text-[10px] md:text-xs text-slate-400 font-medium mt-1 leading-relaxed">Buktikan pemahamanmu di misi evaluasi dan dapatkan tambahan <span class="bg-[#10b981]/20 text-emerald-400 px-1.5 py-0.5 rounded font-black">+{{ $assessment->xp_reward }} XP</span></p>
                    @else
                        <p class="text-[10px] md:text-xs text-rose-400 font-bold mt-1 leading-relaxed">Dosen/Admin belum menambahkan Misi Evaluasi (Kuis) untuk modul ini.</p>
                    @endif
                </div>

                @if($assessment)
                    <form action="{{ route('student.exam.start', $assessment->id) }}" method="POST" class="shrink-0 w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full px-6 py-3 md:px-8 md:py-4 bg-[#10b981] hover:bg-[#059669] text-white text-[11px] md:text-[13px] font-black rounded-xl transition-all shadow-lg active:scale-95 flex items-center justify-center gap-2 md:gap-3 group border border-emerald-400/50 tracking-widest uppercase">
                            MULAI EVALUASI
                            <svg class="w-4 h-4 md:w-5 md:h-5 transform group-hover:translate-x-1.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                @else
                    <button disabled class="shrink-0 w-full sm:w-auto px-6 py-3 md:px-8 md:py-4 bg-slate-800 text-slate-500 text-[11px] md:text-[13px] font-black rounded-xl border border-slate-700 cursor-not-allowed tracking-widest uppercase">
                        BELUM ADA KUIS
                    </button>
                @endif
            </div>

        </div>
    </div>

</body>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        gsap.from(".gsap-fade", { y: 30, opacity: 0, duration: 0.8, stagger: 0.2, ease: "power3.out" });

        const pdfUrl = "{{ $module->document_file ? asset('storage/' . $module->document_file) : '' }}";
        const moduleId = "{{ $module->id }}";

        window.pdfDoc = null;
        window.zoomMultiplier = 1.0; // Zoom multiplier yang dinamis
        window.globalPdfUrl = pdfUrl;
        let hasClaimedReadingXp = false;

        window.pdfObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting && entry.intersectionRatio >= 0.3) {
                    let pageNum = parseInt(entry.target.getAttribute('data-page-num'));
                    document.getElementById('pageNumberInput').value = pageNum;

                    // MENGIRIMKAN PROGRESS 50% SAAT HALAMAN TERAKHIR PDF TERCAPAI
                    if (window.pdfDoc && pageNum === window.pdfDoc.numPages && !hasClaimedReadingXp) {
                        hasClaimedReadingXp = true;
                        fetch(`/student/modul/${moduleId}/update-progress`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({ percentage: 50 })
                        });

                        fetch("{{ route('student.claim_xp') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                            body: JSON.stringify({ xp_amount: 50, type: 'modul', description: 'Membaca PDF: {{ addslashes($module->title) }}' })
                        }).then(res => res.json()).then(data => {
                            if(data.success && typeof Swal !== 'undefined') {
                                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Modul Selesai Dibaca! +50 XP 🚀', showConfirmButton: false, timer: 4000 });
                            }
                        });
                    }
                }
            });
        }, { threshold: 0.3 });

        if (pdfUrl && pdfUrl.trim() !== '') {
            loadStudentPDF(pdfUrl);
        } else {
            document.getElementById('pdfLoading').classList.add('hidden');
            document.getElementById('previewPdfFallback').classList.remove('hidden');
        }
    });

    function renderNextPage(num) {
        if (num > window.pdfDoc.numPages) {
            document.getElementById('pdfLoading').classList.add('hidden');
            return;
        }

        const wrapper = document.createElement('div');
        // PENTING UNTUK MOBILE: max-w-full agar gambar tidak overflow
        wrapper.className = 'w-full max-w-full flex justify-center shadow-[0_10px_30px_rgba(0,0,0,0.5)] bg-white overflow-hidden rounded-xl relative group';
        wrapper.id = 'pdf-page-' + num;
        wrapper.setAttribute('data-page-num', num);

        const canvas = document.createElement('canvas');
        // PENTING UNTUK MOBILE: max-w-full h-auto agar image mengecil jika layar kecil
        canvas.className = 'max-w-full h-auto object-contain block';
        wrapper.appendChild(canvas);
        document.getElementById('pdfPagesContainer').appendChild(wrapper);

        window.pdfObserver.observe(wrapper);

        window.pdfDoc.getPage(num).then(function(page) {
            // 1. Dapatkan ukuran asli (skala 1)
            const unscaledViewport = page.getViewport({ scale: 1.0 });

            // 2. Hitung lebar container yang tersedia
            // Di mobile kita gunakan lebar container (100%), di desktop max 1000px
            const containerWidth = document.getElementById('pdfPagesContainer').clientWidth;
            const screenWidth = window.innerWidth;

            // Beri sedikit padding (misal 32px di mobile)
            const padding = screenWidth < 768 ? 0 : 32;
            const availableWidth = Math.min(containerWidth - padding, 1000);

            // 3. Hitung base scale agar PDF Fit-to-Screen
            let baseScale = availableWidth / unscaledViewport.width;

            // Cegah PDF jadi terlalu raksasa di layar ultra lebar
            if (screenWidth >= 1024) { baseScale = Math.min(baseScale, 1.5); }

            // 4. Terapkan Zoom Multiplier (dari tombol +/-)
            const finalScale = baseScale * window.zoomMultiplier;

            // 5. Render HD (Resolusi Kanvas dikali 3 agar sangat tajam)
            const displayViewport = page.getViewport({ scale: finalScale });
            const renderScale = finalScale * 3;
            const renderViewport = page.getViewport({ scale: renderScale });

            canvas.width = renderViewport.width;
            canvas.height = renderViewport.height;

            // 6. Set CSS Width persis sesuai skala display agar terkompres rapat di layar
            canvas.style.width = Math.floor(displayViewport.width) + "px";
            canvas.style.height = "auto";

            const renderContext = {
                canvasContext: canvas.getContext('2d'),
                viewport: renderViewport
            };

            page.render(renderContext).promise.then(() => {
                renderNextPage(num + 1);
            });
        });
    }

    function renderAllPages() {
        document.getElementById('pdfPagesContainer').innerHTML = '';
        window.pdfObserver.disconnect();
        if (!window.pdfDoc) return;

        document.getElementById('zoomDisplay').innerText = Math.round(window.zoomMultiplier * 100) + "%";
        document.getElementById('pageCountDisplay').innerText = window.pdfDoc.numPages;

        const input = document.getElementById('pageNumberInput');
        input.value = 1;
        input.max = window.pdfDoc.numPages;

        document.getElementById('pdfLoading').classList.remove('hidden');
        renderNextPage(1);
    }

    function loadStudentPDF(url) {
        pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
            window.pdfDoc = pdfDoc_;
            renderAllPages();
        }).catch(function(error) {
            console.error("Error loading PDF: ", error);
            document.getElementById('pdfLoading').classList.add('hidden');
            document.getElementById('previewPdfFallback').classList.remove('hidden');
        });
    }

    window.zoomIn = function() {
        if (!window.pdfDoc || window.zoomMultiplier >= 2.0) return; // Maksimal zoom 200%
        window.zoomMultiplier += 0.2;
        renderAllPages();
    }

    window.zoomOut = function() {
        if (!window.pdfDoc || window.zoomMultiplier <= 0.6) return; // Minimal zoom 60%
        window.zoomMultiplier -= 0.2;
        renderAllPages();
    }

    document.getElementById('pageNumberInput').addEventListener('change', function() {
        let val = parseInt(this.value);
        if(window.pdfDoc && val >= 1 && val <= window.pdfDoc.numPages) {
            const targetPage = document.getElementById('pdf-page-' + val);
            if(targetPage) {
                const scrollArea = document.getElementById('pdfScrollArea');
                const topPos = targetPage.offsetTop - 20;
                scrollArea.scrollTo({ top: topPos, behavior: 'smooth' });
            }
        } else {
            this.value = 1;
        }
    });

    window.printPDF = function() {
        if(!window.globalPdfUrl) return;
        const hideFrame = document.createElement("iframe");
        hideFrame.onload = function() {
            setTimeout(() => { hideFrame.contentWindow.focus(); hideFrame.contentWindow.print(); }, 500);
        };
        hideFrame.style.cssText = "position:fixed;right:0;bottom:0;width:0;height:0;border:0;";
        hideFrame.src = window.globalPdfUrl;
        document.body.appendChild(hideFrame);
    }
</script>
</body>
</html>
