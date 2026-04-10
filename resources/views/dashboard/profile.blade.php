@extends('layouts.app')

@section('title', 'Edit Profile - BACLAB')

@section('content')
<div class="min-h-screen bg-[#0f172a] text-gray-200 font-sans pb-12">
    <nav class="border-b border-white/5 bg-[#0f172a]/80 backdrop-blur-xl px-6 py-4">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <a href="/dashboard" class="text-sm font-medium text-gray-400 hover:text-white transition-colors flex items-center gap-2">
                ← Back to Dashboard
            </a>
            <h1 class="text-lg font-black tracking-tighter text-white">MY <span class="text-blue-500">PROFILE</span></h1>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto px-6 py-12">
        <div class="bg-[#1e293b]/30 border border-white/5 rounded-3xl overflow-hidden backdrop-blur-md shadow-2xl">
            <div class="px-8 py-8 bg-gradient-to-r from-blue-600/10 to-transparent border-b border-white/5">
                <h2 class="text-2xl font-bold text-white">Informasi Akun</h2>
                <p class="text-sm text-gray-500 mt-1">Ubah data diri dan kredensial keamanan kamu.</p>
            </div>

            <form id="profileForm" class="p-8 space-y-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.2em] text-gray-500 mb-2 font-bold">Nama Lengkap</label>
                        <input type="text" id="name" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none transition duration-200">
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.2em] text-gray-500 mb-2 font-bold">Email Address</label>
                        <input type="email" id="email" required disabled
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none transition duration-200">
                    </div>

                    <div class="pt-4 border-t border-white/5">
                        <label class="block text-[10px] uppercase tracking-[0.2em] text-gray-500 mb-2 font-bold text-blue-400">Ganti Password</label>
                        <input type="password" id="password"
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none transition duration-200"
                            placeholder="Isi hanya jika ingin mengganti">
                    </div>
                </div>

                <div class="flex flex-col gap-4 pt-6">
                    <button type="submit"
                        class="w-full py-4 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-xl shadow-lg shadow-blue-500/20 transition-all transform active:scale-[0.98]">
                        UPDATE DATA
                    </button>
                    <p id="msg" class="text-center text-xs font-medium"></p>
                </div>
            </form>
        </div>

        <div class="mt-8 p-6 border border-red-500/20 rounded-2xl bg-red-500/5">
            <h4 class="text-red-400 text-xs font-bold uppercase tracking-widest mb-1">Danger Zone</h4>
            <p class="text-[11px] text-gray-500">Sekali data diperbarui, sesi token mungkin akan memerlukan login ulang untuk sinkronisasi.</p>
        </div>
    </div>
</div>

<script>
    const token = localStorage.getItem('token');
    if (!token) window.location.href = '/login';

    const pathParts = window.location.pathname.split('/');
    const userId = pathParts[pathParts.length - 1];

    async function getProfile() {
        if (!userId) {
            console.error("UUID target tidak ditemukan di URL!");
            return;
        }

        try {
            const res = await fetch(`/api/profile/${userId}`, {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });

            const user = await res.json();

            if (res.ok) {
                document.getElementById('name').value = user.name || '';
                document.getElementById('email').value = user.email || '';
                if(document.getElementById('target-uuid')) {
                    document.getElementById('target-uuid').textContent = user.id;
                }
            } else {
                console.error("User tidak ditemukan atau unauthorized");
            }
        } catch (err) {
            console.error("Gagal load profile:", err);
        }
    }

    document.getElementById('profileForm').onsubmit = async (e) => {
        e.preventDefault();
        const msg = document.getElementById('msg');
        msg.textContent = 'Memproses...';
        msg.className = 'text-center text-xs text-blue-400';

        const payload = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
        };

        const pwd = document.getElementById('password').value;
        if(pwd) payload.password = pwd;

        try {
            const res = await fetch(`/api/profile/${userId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const result = await res.json();
            if (res.ok) {
                msg.textContent = 'Data berhasil dioverwrite!';
                msg.className = 'text-center text-xs text-green-400';
            } else {
                msg.textContent = 'Gagal: ' + (result.message || 'Terjadi kesalahan');
                msg.className = 'text-center text-xs text-red-400';
            }
        } catch (err) {
            msg.textContent = 'Gagal terhubung ke server';
            msg.className = 'text-center text-xs text-red-400';
        }
    }
    getProfile();
</script>
@endsection
