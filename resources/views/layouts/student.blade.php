<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Dashboard | SMART-ECO')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: { colors: { eco: { blue: '#1e3a8a', green: '#10b981', dark: '#0f172a' } } }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar-sidebar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar-sidebar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar-sidebar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    </style>
</head>
<body class="text-slate-800 bg-[#f4f7f6] overflow-hidden flex flex-col h-[100dvh]" x-data="{ sidebarOpen: false }">

    @include('components.student-header')

    <div class="flex flex-1 overflow-hidden relative w-full">

        <!-- Sidebar Desktop -->
        <div class="hidden lg:block h-full py-4 pl-4 shrink-0 z-10 w-[260px]">
            @include('components.student-sidebar')
        </div>

        <!-- Sidebar Mobile Overlay -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-50 flex lg:hidden" x-cloak>
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="sidebarOpen = false" x-transition.opacity></div>

            <div class="relative flex-1 flex flex-col max-w-[260px] w-full shadow-2xl transition-transform duration-300 ease-in-out"
                 x-show="sidebarOpen"
                 x-transition:enter="transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full">
                @include('components.student-sidebar')
            </div>
        </div>

        <!-- Area Konten Utama -->
        <main class="flex-1 overflow-y-auto bg-slate-50 flex flex-col custom-scrollbar">
            <div class="flex-1 p-4 sm:p-6 md:p-8">
                @yield('content')
            </div>

            @include('components.footer')
        </main>

    </div>

    @stack('scripts')
</body>
</html>
