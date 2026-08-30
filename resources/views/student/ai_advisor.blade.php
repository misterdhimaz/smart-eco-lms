@extends('layouts.student')
@section('title', 'AI Sustainability Advisor | SMART-ECO')

@section('content')
<div class="w-full h-[calc(100vh-6rem)] md:h-[calc(100vh-5rem)] flex items-center justify-center p-4 lg:p-6 font-sans relative">

    <div x-data="aiAdvisor('{{ $user->name ?? 'Eco Learner' }}')" x-init="initChat()" class="w-full max-w-4xl h-full bg-white rounded-[2rem] shadow-[0_20px_60px_rgba(0,0,0,0.08)] border border-slate-200 flex flex-col overflow-hidden relative z-10 gsap-window">

        <div class="bg-gradient-to-r from-[#0f172a] to-[#1e293b] px-6 py-5 flex items-center justify-between shrink-0 z-20 relative overflow-hidden">
            <div class="absolute right-[-10%] top-[-50%] w-48 h-48 bg-emerald-500/20 rounded-full blur-[40px] pointer-events-none"></div>

            <div class="flex items-center gap-4 relative z-10">
                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center border border-white/20 backdrop-blur-sm shadow-inner">
                    <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h.01M15 9h.01"></path></svg>
                </div>
                <div>
                    <h1 class="text-xl font-black text-white tracking-wide">AI SUSTAINABILITY ADVISOR</h1>
                    <p class="text-xs font-medium text-emerald-300">Powered by Groq AI • Llama 3.1</p>
                </div>
            </div>

            <button @click="clearChat()" class="relative z-10 text-[11px] font-bold text-slate-300 hover:text-white transition-colors flex items-center gap-2 bg-white/5 hover:bg-rose-500/80 px-4 py-2 rounded-xl border border-white/10 hover:border-rose-500 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                <span class="hidden sm:inline">Reset Obrolan</span>
            </button>
        </div>

        <div id="chatContainer" class="flex-1 overflow-y-auto p-6 md:p-8 space-y-6 bg-slate-50 relative custom-scrollbar">

            <template x-if="messages.length === 0">
                <div class="flex flex-col items-center justify-center h-full text-center max-w-xl mx-auto gsap-welcome">

                    <div class="relative w-32 h-32 mb-6">
                        <div class="absolute inset-0 bg-emerald-400 rounded-full blur-[30px] opacity-20 animate-pulse"></div>
                        <div class="relative w-full h-full bg-white rounded-3xl shadow-xl border border-slate-100 flex flex-col items-center justify-center pt-2">
                            <div class="absolute -top-3 w-1.5 h-4 bg-slate-300 rounded-t-full"><div class="absolute -top-1.5 -left-1 w-3 h-3 bg-emerald-500 rounded-full"></div></div>
                            <div class="flex gap-4 mb-2">
                                <div class="w-5 h-5 bg-slate-800 rounded-full flex items-center justify-center"><div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div></div>
                                <div class="w-5 h-5 bg-slate-800 rounded-full flex items-center justify-center"><div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div></div>
                            </div>
                            <div class="w-8 h-2.5 border-b-4 border-slate-300 rounded-b-full"></div>
                            <div class="absolute -bottom-4 w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center border-4 border-white shadow-sm text-emerald-500">🌱</div>
                        </div>
                    </div>

                    <h2 class="text-2xl font-black text-slate-800 mb-2">Halo, <span x-text="userName"></span>!</h2>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed mb-8">
                        Saya EcoBot! Tanyakan apa saja tentang sains, fisika, energi terbarukan, hingga tips keberlanjutan lingkungan.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 w-full text-left">
                        <template x-for="prompt in quickPrompts">
                            <button @click="sendQuickPrompt(prompt.text)" class="bg-white border border-slate-200 hover:border-emerald-400 p-4 rounded-2xl transition-all hover:shadow-md group">
                                <p class="text-sm font-black text-slate-700 group-hover:text-emerald-600 leading-snug" x-text="prompt.title"></p>
                            </button>
                        </template>
                    </div>
                </div>
            </template>

            <div class="space-y-6 pb-4">
                <template x-for="msg in messages" :key="msg.id">
                    <div class="flex w-full" :class="msg.sender === 'user' ? 'justify-end' : 'justify-start'">

                        <div class="max-w-[90%] md:max-w-[80%] flex flex-col" :class="msg.sender === 'user' ? 'items-end' : 'items-start'">

                            <span class="text-[11px] font-black mb-1.5 px-2 tracking-wide"
                                  :class="msg.sender === 'user' ? 'text-slate-500' : 'text-emerald-600'"
                                  x-text="msg.sender === 'user' ? userName : 'AI Advisor'"></span>

                            <div class="p-5 text-[14.5px] leading-relaxed shadow-sm relative"
                                 :class="msg.sender === 'user'
                                    ? 'bg-slate-100 text-slate-800 rounded-2xl rounded-tr-sm border border-slate-200'
                                    : 'bg-[#f0fdf4] border border-emerald-100 text-emerald-950 rounded-2xl rounded-tl-sm'">
                                <div x-html="msg.text" class="prose prose-sm max-w-none font-medium"></div>
                            </div>
                        </div>

                    </div>
                </template>

                <div x-show="isTyping" class="flex w-full justify-start" style="display: none;">
                    <div class="max-w-[80%] flex flex-col items-start">
                        <span class="text-[11px] font-black mb-1.5 px-2 tracking-wide text-emerald-600">AI Advisor</span>
                        <div class="bg-[#f0fdf4] border border-emerald-100 p-5 rounded-2xl rounded-tl-sm shadow-sm flex items-center gap-1.5 h-12">
                            <div class="w-2.5 h-2.5 bg-emerald-400 rounded-full animate-bounce"></div>
                            <div class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-bounce" style="animation-delay: 0.15s"></div>
                            <div class="w-2.5 h-2.5 bg-emerald-600 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="bg-white border-t border-slate-200 p-4 shrink-0 z-20">
            <form @submit.prevent="sendMessage" class="relative w-full flex items-center gap-3">
                <div class="flex-1 bg-slate-50 border-2 border-slate-200 rounded-2xl overflow-hidden focus-within:border-emerald-500 focus-within:bg-white transition-all flex items-center px-4 py-1">
                    <input
                        type="text"
                        x-model="inputText"
                        placeholder="Ketik pertanyaan Anda tentang fisika / lingkungan..."
                        class="w-full bg-transparent py-3 text-[14px] font-medium text-slate-700 outline-none"
                    />
                </div>

                <button type="submit" :disabled="!inputText.trim() || isTyping" class="w-12 h-12 shrink-0 bg-emerald-600 hover:bg-emerald-700 disabled:bg-slate-200 disabled:text-slate-400 text-white rounded-xl flex items-center justify-center transition-all shadow-md hover:shadow-lg hover:shadow-emerald-500/20 active:scale-95 group">
                    <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </form>
        </div>

    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>
    function aiAdvisor(userNameParam) {
        return {
            userName: userNameParam,
            inputText: '',
            messages: [],
            isTyping: false,

            // API Key Groq langsung dari .env
            groqApiKey: '{{ env("GROQ_API_KEY") }}',

            quickPrompts: [
                { title: "Bagaimana cara kerja panel surya? ☀️", text: "Jelaskan prinsip fisika di balik panel surya." },
                { title: "Cara kurangi emisi karbon harian 🌿", text: "Bagaimana cara mengurangi emisi karbon harian saya?" },
                { title: "Apa itu Hukum Termodinamika? 🔥", text: "Jelaskan hukum termodinamika kaitannya dengan energi." },
                { title: "Mengapa es kutub mencair? 🧊", text: "Jelaskan efek rumah kaca secara fisika." }
            ],

            initChat() {
                gsap.from(".gsap-window", { y: 30, opacity: 0, duration: 0.8, ease: "power3.out" });
                gsap.from(".gsap-welcome", { scale: 0.95, opacity: 0, duration: 0.6, delay: 0.3, ease: "back.out(1.2)" });
            },

            scrollToBottom() {
                setTimeout(() => {
                    const container = document.getElementById('chatContainer');
                    if(container) container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
                }, 100);
            },

            sendQuickPrompt(text) {
                this.inputText = text;
                this.sendMessage();
            },

            clearChat() {
                this.messages = [];
            },

            sendMessage() {
                const text = this.inputText.trim();
                if (!text || this.isTyping) return;

                this.messages.push({
                    id: Date.now(),
                    sender: 'user',
                    text: text
                });

                this.inputText = '';
                this.scrollToBottom();
                this.isTyping = true;

                this.generateAiResponse(text);
            },

            async generateAiResponse(userMessage) {
                let aiReplyText = "";

                try {
                    // Panggil ke Route Backend Laravel Anda (AdminController@chatAI / chatGroq)
                    const res = await fetch("{{ route('admin.chatAI') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Amankan dengan CSRF
                        },
                        body: JSON.stringify({ message: userMessage })
                    });

                    const data = await res.json();

                    if (res.ok && data.reply) {
                        // Backend Laravel (Str::markdown) sudah mengirimkan format HTML jadi tidak perlu Marked.js lagi
                        aiReplyText = data.reply;
                    } else {
                        throw new Error(data.error || 'Terjadi kesalahan dari server');
                    }

                } catch (error) {
                    aiReplyText = `<div class="p-3 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl font-medium text-xs">
                        ⚠️ <strong>Koneksi Gagal:</strong> ${error.message}
                    </div>`;
                }

                this.isTyping = false;
                this.messages.push({
                    id: Date.now(),
                    sender: 'ai',
                    text: aiReplyText
                });
                this.scrollToBottom();
            }
        }
    }
</script>
@endpush
