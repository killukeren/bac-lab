@extends('layouts.app')

@section('title', 'MLBB Chat - Welcome')

@section('content')
<div class="relative z-0 min-h-screen bg-[#0f172a] overflow-hidden flex items-center justify-center font-sans">

    <div class="absolute top-0 -left-4 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
    <div class="absolute bottom-0 -right-4 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>

    <div class="absolute inset-0 -z-10 flex items-center justify-center scale-110 pointer-events-none opacity-20">
        <img src="https://akmweb.youngjoygame.com/web/gms/image/24c43180662d27aa5b62106b596fa4f7.webp"
             alt="Natan MLBB Hero Background"
             class="h-[130vh] w-auto object-contain filter blur-[1px] transform rotate-[-8deg] scale-150">
    </div>

    <div class="absolute inset-0 -z-10 bg-[#0f172a]/80 backdrop-blur-sm"></div>

    <div class="relative z-10 max-w-5xl w-full px-6 flex flex-col items-center text-center pointer-events-auto">

        <h1 class="text-5xl md:text-7xl font-black text-white mb-6 tracking-tight leading-none">
            STRATEGIZE.<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-500">
                CHAT. DOMINATE.
            </span>
        </h1>

        <p class="text-gray-400 text-lg md:text-xl mb-12 max-w-2xl leading-relaxed bg-[#0f172a]/50 p-4 rounded-xl backdrop-blur-sm border border-white/5">
            Platform komunikasi khusus squad MLBB. Diskusi draft pick, laning, hingga analisis meta dalam satu dashboard yang simpel.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 w-full justify-center mt-6">
            <a href="/login"
               class="group relative px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl transition-all hover:bg-blue-500 hover:shadow-[0_0_20px_rgba(37,99,235,0.4)] active:scale-95 text-center overflow-hidden">
               <span class="relative z-10">Mulai Chatting</span>
            </a>

            <a href="/register"
               class="px-8 py-4 bg-white/5 border border-white/10 text-white font-bold rounded-2xl backdrop-blur-md hover:bg-white/10 transition-all active:scale-95 text-center p-4">
                Buat Akun Baru
            </a>
        </div>

        <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8 w-full border-t border-white/5 pt-12 pb-12">
            <div class="p-6 rounded-2xl bg-white/[0.02] border border-white/[0.05]">
                <h3 class="text-blue-400 font-bold mb-2">Group Access</h3>
                <p class="text-gray-500 text-sm text-balance">Masuk ke grup mana saja dengan sistem routing yang dinamis.</p>
            </div>
            <div class="p-6 rounded-2xl bg-white/[0.02] border border-white/[0.05]">
                <h3 class="text-blue-400 font-bold mb-2">Real-time Feed</h3>
                <p class="text-gray-500 text-sm text-balance">Update pesan cepat untuk respon strategi kilat di dalam game.</p>
            </div>
            <div class="p-6 rounded-2xl bg-white/[0.02] border border-white/[0.05]">
                <h3 class="text-blue-400 font-bold mb-2">Lab Environment</h3>
                <p class="text-gray-500 text-sm text-balance">Didesain khusus untuk simulasi celah keamanan web (BAC/IDOR).</p>
            </div>
        </div>

    </div>
</div>

<style>
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
</style>
@endsection
