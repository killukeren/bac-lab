@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-950 px-4 py-10">
    <div class="bg-slate-900 border border-slate-800 p-8 rounded-2xl shadow-2xl w-full max-w-md transition-all">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-white italic">
                MLBB<span class="text-blue-500">CHAT</span>
            </h1>
            <div class="h-1 w-12 bg-blue-600 mx-auto mt-2 rounded-full"></div>
            <p class="text-slate-400 text-xs mt-3 uppercase tracking-widest font-semibold">Mabar Chat Dashboard</p>
        </div>

        <div id="alert-error" class="hidden animate-pulse border-l-4 border-red-500 bg-red-500/10 text-red-400 text-sm px-4 py-3 rounded-md mb-4"></div>
        <div id="alert-success" class="hidden border-l-4 border-green-500 bg-green-500/10 text-green-400 text-sm px-4 py-3 rounded-md mb-4"></div>

        <div class="space-y-5">
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1 ml-1">Full Identity (Name)</label>
                <input id="name" type="text" placeholder="e.g. Faiz Ahmad"
                    class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white text-sm placeholder:text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1 ml-1">Contact Point (Email)</label>
                <input id="email" type="email" placeholder="name@company.com"
                    class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white text-sm placeholder:text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1 ml-1">Secret Key (Password)</label>
                <input id="password" type="password" placeholder="min. 8 characters"
                    class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white text-sm placeholder:text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all">
            </div>

            <input type="hidden" id="role" value="karyawan">

            <button onclick="register()"
                class="group relative w-full bg-slate-100 hover:bg-white text-slate-900 font-bold py-3 rounded-xl text-sm transition-all shadow-lg active:scale-95 mt-2">
                <span class="relative z-10">REQUEST ACCESS</span>
            </button>
        </div>

        <div class="mt-8 pt-6 border-t border-slate-800 text-center">
            <p class="text-xs text-slate-400">
                Already have credentials?
                <a href="/login" class="text-blue-400 hover:text-blue-300 font-semibold transition underline-offset-4 hover:underline">Return to Terminal</a>
            </p>
        </div>
    </div>
</div>

<script>
async function register() {
    const name      = document.getElementById('name').value;
    const email     = document.getElementById('email').value;
    const password  = document.getElementById('password').value;
    const role      = document.getElementById('role').value;
    const alertErr  = document.getElementById('alert-error');
    const alertOk   = document.getElementById('alert-success');

    alertErr.classList.add('hidden');
    alertOk.classList.add('hidden');

    const res = await fetch('/api/register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({ name, email, password, role }), // ← role ikut dikirim!
    });

    const data = await res.json();

    if (!res.ok) {
        alertErr.classList.remove('hidden');
        alertErr.textContent = data.message ?? JSON.stringify(data.errors);
        return;
    }

    // Simpan token & langsung ke dashboard
    localStorage.setItem('token', data.token);
    localStorage.setItem('user', JSON.stringify(data.data));

    alertOk.classList.remove('hidden');
    alertOk.textContent = `Akun berhasil dibuat sebagai ${data.data.role}!`;

    setTimeout(() => window.location.href = '/dashboard', 1000);
}
</script>
@endsection
