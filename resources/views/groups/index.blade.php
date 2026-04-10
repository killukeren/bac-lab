@extends('layouts.app')
@section('title', 'Groups')

@section('content')
<div class="min-h-screen">

    <div class="min-h-screen bg-[#0f172a] text-gray-200 font-sans pb-12">
    <nav class="border-b border-white/5 bg-[#0f172a]/80 backdrop-blur-xl sticky top-0 z-50 px-6 py-4">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-6">
                <h1 class="text-xl font-black tracking-tighter text-white">MLBB<span class="text-blue-500">CHAT</span></h1>
                <div class="h-4 w-[1px] bg-white/10"></div>
                <a href="/dashboard" class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Dashboard</a>
                <a href="/groups" class="text-sm font-bold text-blue-400 border-b-2 border-blue-500 pb-1">Groups</a>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p id="user-name" class="text-sm font-bold text-white leading-none"></p>
                    <p id="user-role" class="text-[10px] uppercase tracking-widest text-blue-400 mt-1"></p>
                </div>
                <button onclick="logout()" class="px-3 py-1.5 bg-red-500/10 hover:bg-red-500/20 text-red-500 rounded-lg text-[11px] font-bold transition-all border border-red-500/20">LOGOUT</button>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-6 py-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
            <div>
                <h2 class="text-3xl font-bold text-white tracking-tight">Group Management</h2>
                <p class="text-gray-400 text-sm mt-1 italic">Sistem komunikasi terenkripsi antar squad.</p>
            </div>

            <button id="btn-create" onclick="openModal()"
                class="hidden group relative px-6 py-3 bg-blue-600 text-white text-sm font-bold rounded-xl transition-all hover:bg-blue-500 hover:shadow-[0_0_20px_rgba(37,99,235,0.3)] active:scale-95">
                <span class="relative z-10 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                    BUAT GRUP BARU
                </span>
            </button>
        </div>

        <div id="group-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="col-span-full flex justify-center py-20">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
            </div>
        </div>

        <div id="empty-state" class="hidden flex-col items-center justify-center py-24 bg-[#1e293b]/20 border border-dashed border-white/10 rounded-3xl text-center">
            <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mb-4">
                <p class="text-4xl opacity-50">👥</p>
            </div>
            <p class="text-gray-400 font-medium">Belum ada grup yang tersedia.</p>
            <p class="text-xs text-gray-600 mt-1">Hanya Admin yang dapat membuat grup baru.</p>
        </div>
    </div>
</div>

<div id="modal" class="fixed inset-0 hidden items-center justify-center bg-[#0f172a]/90 backdrop-blur-sm z-[100]" style="display:none">
    <div class="bg-[#1e293b] border border-white/10 rounded-3xl shadow-2xl p-8 w-full max-w-md mx-4 transform transition-all">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-white">Initialize New Group</h3>
            <button onclick="closeModal()" class="text-gray-500 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="space-y-5">
            <div>
                <label class="text-[10px] uppercase tracking-widest text-gray-500 mb-2 block font-bold">Group Name</label>
                <input id="group-name" type="text" placeholder="Masukkan nama squad..."
                    class="w-full bg-[#0f172a] border border-white/5 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>
            <div>
                <label class="text-[10px] uppercase tracking-widest text-gray-500 mb-2 block font-bold">Group Brief</label>
                <textarea id="group-desc" placeholder="Deskripsi strategi..." rows="3"
                    class="w-full bg-[#0f172a] border border-white/5 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none transition"></textarea>
            </div>
            <div>
                <label class="text-[10px] uppercase tracking-widest text-gray-500 mb-2 block font-bold">Whitelist Members</label>
                <div id="user-checkboxes" class="space-y-2 max-h-48 overflow-y-auto bg-[#0f172a] border border-white/5 rounded-xl p-4 custom-scrollbar">
                    </div>
            </div>
        </div>

        <div id="modal-alert" class="hidden mt-4 p-3 bg-red-500/10 border border-red-500/20 rounded-xl text-xs text-red-400"></div>

        <div class="grid grid-cols-2 gap-4 mt-8">
            <button onclick="closeModal()"
                class="px-4 py-3 border border-white/10 text-gray-400 text-sm font-bold rounded-xl hover:bg-white/5 transition">
                BATAL
            </button>
            <button onclick="createGroup()"
                class="px-4 py-3 bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-600/20 transition transform active:scale-95">
                CREATE UNIT
            </button>
        </div>
    </div>
</div>

<style>
    /* Styling Scrollbar */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
</style>
</div>

<!-- Modal Buat Grup -->
<div id="modal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-40 z-50" style="display:none">
    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Buat Grup Baru</h3>

        <div class="space-y-4">
            <div>
                <label class="text-sm font-medium text-gray-700">Nama Grup</label>
                <input id="group-name" type="text" placeholder="Nama grup..."
                    class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="group-desc" placeholder="Deskripsi grup..." rows="2"
                    class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Tambah Member</label>
                <div id="user-checkboxes" class="space-y-2 max-h-40 overflow-y-auto border border-gray-200 rounded-lg p-3"></div>
            </div>
        </div>

        <div id="modal-alert" class="hidden mt-3 text-xs text-red-500"></div>

        <div class="flex gap-3 mt-5">
            <button onclick="closeModal()"
                class="flex-1 border border-gray-300 text-gray-700 text-sm py-2 rounded-lg hover:bg-gray-50 transition">
                Batal
            </button>
            <button onclick="createGroup()"
                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm py-2 rounded-lg transition">
                Buat Grup
            </button>
        </div>
    </div>
</div>

<script>
const token = localStorage.getItem('token');
const user  = JSON.parse(localStorage.getItem('user') || '{}');

if (!token) window.location.href = '/login';

// Set navbar
document.getElementById('user-name').textContent = user.name;
document.getElementById('user-role').textContent  = user.role;

// Tampilkan tombol buat grup untuk admin/superadmin
if (user.role === 'admin' || user.role === 'superadmin') {
    document.getElementById('btn-create').classList.remove('hidden');
    loadAllUsers();
}

loadGroups();

// ── Load grup milik sendiri ──────────────────────────
async function loadGroups() {
    const endpoint = (user.role === 'admin' || user.role === 'superadmin')
        ? '/api/groups/all'
        : '/api/groups';

    const res  = await fetch(endpoint, {
        headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
    });

    const json = await res.json();
    console.log('groups:', json);
    const list = document.getElementById('group-list');

    if (!json.data || json.data.length === 0) {
        document.getElementById('empty-state').classList.remove('hidden');
        return;
    }

    list.innerHTML = json.data.map(g => {
        const memberList = g.member.map(m => {
            const roleBadge = m.role === 'superadmin' ? 'bg-red-100 text-red-700' :
                            m.role === 'admin'       ? 'bg-yellow-100 text-yellow-700' :
                                                        'bg-green-100 text-green-700';

            const kickBtn = (user.role === 'admin' || user.role === 'superadmin') && m.id !== user.id
                ? `<button onclick="kickMember(${g.id}, ${m.id})" class="text-xs text-red-500 hover:underline">Kick</button>`
                : '';

            return `
                <div class="flex justify-between items-center bg-gray-50 rounded-lg px-3 py-2">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-700">${m.name}</span>
                        <span class="text-xs px-2 py-0.5 rounded-full ${roleBadge}">${m.role}</span>
                    </div>
                    ${kickBtn}
                </div>`;
        }).join('');

        return `
            <div class="bg-white rounded-xl shadow-sm p-5">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="font-semibold text-gray-800">${g.name}</p>
                        <p class="text-xs text-gray-400 mt-1">${g.description ?? 'Tidak ada deskripsi'}</p>
                    </div>
                    <a href="/groups/${g.id}/chat"   // ← tombol masuk chat
                        class="text-xs bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg">
                        Masuk Chat
                    </a>
                </div>
            </div>`;
    }).join('');
}

// ── Load semua user untuk checkbox di modal ──────────
async function loadAllUsers() {
    const res  = await fetch('/api/users', {
        headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
    });
    const json = await res.json();

    const container = document.getElementById('user-checkboxes');
    container.innerHTML = json.data
        .filter(u => u.id !== user.id)
        .map(u => `
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" value="${u.id}" class="member-cb rounded">
                <span class="text-sm text-gray-700">${u.name}</span>
                <span class="text-xs text-gray-400">${u.role}</span>
            </label>
        `).join('');
}

// ── Buat grup ────────────────────────────────────────
async function createGroup() {
    const name    = document.getElementById('group-name').value;
    const desc    = document.getElementById('group-desc').value;
    const members = [...document.querySelectorAll('.member-cb:checked')].map(c => c.value);
    const alert   = document.getElementById('modal-alert');

    if (!name) {
        alert.classList.remove('hidden');
        alert.textContent = 'Nama grup wajib diisi!';
        return;
    }

    const res = await fetch('/api/groups', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + token,
        },
        body: JSON.stringify({ name, description: desc, members }),
    });

    const json = await res.json();

    if (!res.ok) {
        alert.classList.remove('hidden');
        alert.textContent = json.message ?? 'Gagal membuat grup';
        return;
    }

    closeModal();
    loadGroups();
}


// ── Modal ────────────────────────────────────────────
function openModal()  {
    document.getElementById('modal').style.display = 'flex';
}
function closeModal() {
    document.getElementById('modal').style.display = 'none';
    document.getElementById('group-name').value = '';
    document.getElementById('group-desc').value = '';
    document.getElementById('modal-alert').classList.add('hidden');
}

// ── Logout ───────────────────────────────────────────
async function logout() {
    await fetch('/api/logout', {
        method: 'POST',
        headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
    });
    localStorage.clear();
    window.location.href = '/login';
}

async function kickMember(groupId, userId) {
    if (!confirm('Yakin kick member ini?')) return;

    const res = await fetch(`/api/groups/${groupId}/kick`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + token,
        },
        body: JSON.stringify({ user_id: userId }),
    });

    const json = await res.json();

    if (res.ok) {
        loadGroups(); // refresh list
    } else {
        alert(json.message);
    }
}
</script>
@endsection
