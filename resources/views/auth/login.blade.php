@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-950 px-4">
    <div class="bg-slate-900 border border-slate-800 p-8 rounded-2xl shadow-2xl w-full max-w-md transition-all">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-white italic">
                MLBB<span class="text-blue-500">CHAT</span>
            </h1>
            <div class="h-1 w-12 bg-blue-600 mx-auto mt-2 rounded-full"></div>
            <p class="text-slate-400 text-xs mt-3 uppercase tracking-widest font-semibold">Mabar Chat Dashboard</p>
        </div>

        <div id="alert" class="hidden animate-pulse border-l-4 border-red-500 bg-red-500/10 text-red-400 text-sm px-4 py-3 rounded-md mb-6">
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                <span id="alert-message"></span>
            </div>
        </div>

        <div class="space-y-5">
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1 ml-1">Terminal ID (Email)</label>
                <input id="email" type="email" placeholder="admin@ensec.my.id"
                    class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white text-sm placeholder:text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1 ml-1">Access Token (Password)</label>
                <input id="password" type="password" placeholder="••••••••"
                    class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white text-sm placeholder:text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all">
            </div>

            <button onclick="login()"
                class="group relative w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-xl text-sm transition-all shadow-lg shadow-blue-900/20 active:scale-95">
                <span class="relative z-10">LOGIN DASHBOARD</span>
                <div class="absolute inset-0 bg-white/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </button>
        </div>

        <div class="mt-8 pt-6 border-t border-slate-800 text-center">
            <p class="text-xs text-slate-400 mt-2">
                New User?
                <a href="/register" class="text-blue-400 hover:text-blue-300 font-semibold transition underline-offset-4 hover:underline">Apply for Access</a>
            </p>
        </div>
    </div>
</div>

<script>
async function login() {
    const email    = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const alert    = document.getElementById('alert');

    const res = await fetch('/api/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({ email, password }),
    });

    const data = await res.json();

    if (!res.ok) {
        alert.classList.remove('hidden');
        alert.textContent = data.message;
        return;
    }

    // Simpan token & user ke localStorage
    localStorage.setItem('token', data.token);
    localStorage.setItem('user', JSON.stringify(data.data));

    window.location.href = '/dashboard';
}
</script>
@endsection
