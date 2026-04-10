@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen">

   <div class="min-h-screen bg-[#0f172a] text-gray-200 font-sans pb-12">
    <nav class="border-b border-white/5 bg-[#0f172a]/80 backdrop-blur-xl sticky top-0 z-50 px-6 py-4">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-6">
                <h1 class="text-xl font-black tracking-tighter text-white">
                    MLBB<span class="text-blue-500">CHAT</span>
                </h1>
                <div class="h-4 w-[1px] bg-white/10"></div>
                <a href="/groups" class="text-sm font-medium text-gray-400 hover:text-blue-400 transition-colors">Groups</a>
            </div>

            <div class="flex items-center gap-6">
                <div class="flex flex-col items-end">
                    <span id="user-name" class="text-sm font-bold text-white leading-none"></span>
                    <span id="user-role" class="text-[10px] uppercase tracking-widest text-blue-400 mt-1"></span>
                </div>
                <div class="flex items-center gap-4">
                    <span id="user-name" class="text-white font-bold"></span>
                    <a id="my-profile-link" href="#" class="text-xs bg-blue-600 hover:bg-blue-500 px-3 py-1 rounded-lg text-white transition">
                        My Profile
                    </a>
                </div>
                <button onclick="logout()"
                    class="px-4 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-500 rounded-lg text-xs font-bold transition-all border border-red-500/20">
                    LOGOUT
                </button>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-6 py-10">
        <div class="mb-10">
            <h2 class="text-3xl font-bold text-white">Dashboard</h2>
            <p class="text-gray-400 text-sm mt-1">Informasi akun dan manajemen akses sistem.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl blur opacity-10 group-hover:opacity-20 transition"></div>
                <div class="relative bg-[#1e293b]/50 border border-white/5 p-6 rounded-2xl">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-gray-500 mb-2">Access Level</p>
                    <p id="stat-role" class="text-2xl font-black text-white">—</p>
                    <div class="absolute bottom-4 right-4 text-blue-500/20 italic font-black text-4xl">01</div>
                </div>
            </div>

            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl blur opacity-10 group-hover:opacity-20 transition"></div>
                <div class="relative bg-[#1e293b]/50 border border-white/5 p-6 rounded-2xl">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-gray-500 mb-2">Primary Email</p>
                    <p id="stat-email" class="text-xl font-bold text-white truncate">—</p>
                    <div class="absolute bottom-4 right-4 text-indigo-500/20 italic font-black text-4xl">02</div>
                </div>
            </div>

            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-2xl blur opacity-10 group-hover:opacity-20 transition"></div>
                <div class="relative bg-[#1e293b]/50 border border-white/5 p-6 rounded-2xl">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-gray-500 mb-2">User Identifier</p>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-500">UID#</span>
                        <p id="stat-id" class="text-2xl font-black text-white">—</p>
                    </div>
                    <div class="absolute bottom-4 right-4 text-cyan-500/20 italic font-black text-4xl">03</div>
                </div>
            </div>
        </div>

        <div id="user-section" class="hidden animate-in fade-in slide-in-from-bottom-4 duration-700">
            <div class="bg-[#1e293b]/30 border border-white/5 rounded-3xl overflow-hidden backdrop-blur-sm">
                <div class="px-8 py-6 border-b border-white/5 flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-xl text-white">Database User</h2>
                        <p class="text-xs text-gray-500">Hanya terlihat oleh Admin & Superadmin</p>
                    </div>
                    <div class="px-3 py-1 bg-blue-500/10 border border-blue-500/20 rounded-md text-[10px] font-bold text-blue-400 uppercase tracking-widest">
                        Privileged Access
                    </div>
                </div>

                <div class="p-4">
                    <div id="user-list" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    body { background-color: #0f172a; }

    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #0f172a; }
    ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #334155; }
    .user-card {
        @apply flex items-center justify-between p-4 bg-white/5 border border-white/5 rounded-xl hover:bg-white/10 transition-all;
    }
</style>
</div>

<script>
    const token = localStorage.getItem('token');
    const userData = JSON.parse(localStorage.getItem('user') || '{}');

    if (!token || !userData.id) {
        window.location.href = '/login';
    }

    try {
        document.getElementById('my-profile-link').href = `/profile/${userData.id}`;
        document.getElementById('user-name').textContent  = userData.name;
        document.getElementById('user-role').textContent  = userData.role;
        document.getElementById('stat-role').textContent  = userData.role;
        document.getElementById('stat-email').textContent = userData.email;
        document.getElementById('stat-id').textContent    = userData.id.substring(0, 8) + '...';
    } catch (e) {
        console.warn("Beberapa elemen UI tidak ditemukan:", e.message);
    }

    if (userData.role === 'admin' || userData.role === 'superadmin') {
        loadUsers();
    }

    async function loadUsers() {
        try {
            const res = await fetch('/api/users', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
            const json = await res.json();

            if (!res.ok) return;

            document.getElementById('user-section').classList.remove('hidden');
            const list = document.getElementById('user-list');

            const users = json.data || json;

            list.innerHTML = users.map(u => `
                <div class="flex justify-between items-center border border-white/5 bg-slate-800/50 rounded-xl px-4 py-3 text-sm hover:bg-white/5 transition-all">
                    <div>
                        <p class="font-medium text-white">${u.name}</p>
                        <p class="text-gray-500 text-[10px] font-mono mt-0.5">${u.id}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-[9px] px-2 py-0.5 rounded-full font-bold uppercase tracking-tighter
                            ${u.role === 'superadmin' ? 'bg-red-500/20 text-red-400' :
                              u.role === 'admin'      ? 'bg-yellow-500/20 text-yellow-400' :
                                                        'bg-green-500/20 text-green-400'}">
                            ${u.role}
                        </span>
                        <a href="/profile/${u.id}" class="text-blue-400 hover:text-blue-300 text-xs font-bold transition p-2 bg-blue-500/5 rounded-lg">
                            EDIT
                        </a>
                    </div>
                </div>
            `).join('');
        } catch (err) {
            console.error("Gagal mengambil daftar user:", err);
        }
    }

    async function logout() {
        if (!confirm('Yakin ingin logout?')) return;

        try {
            await fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
        } catch (e) {}

        localStorage.clear();
        window.location.href = '/login';
    }
</script>
@endsection
