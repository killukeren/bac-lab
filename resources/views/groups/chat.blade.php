@extends('layouts.app')
@section('title', 'Chat')

@section('content')
<div class="min-h-screen flex flex-col">
<div class="min-h-screen bg-[#0f172a] flex flex-col font-sans text-gray-200">

    <nav class="bg-[#1e293b]/80 backdrop-blur-md border-b border-white/5 px-6 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-4">
            <a href="/groups" class="p-2 hover:bg-white/5 rounded-full transition-colors group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 id="group-name" class="text-lg font-black text-white leading-none">Loading...</h1>
                <p class="text-[10px] text-blue-400 uppercase tracking-widest mt-1">Encrypted Room</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <p id="user-name" class="text-sm font-bold text-white leading-none"></p>
                <p id="user-role" class="text-[9px] text-blue-400 font-mono mt-1 uppercase tracking-tighter"></p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center font-black text-white shadow-lg shadow-blue-500/20">
                <span id="user-initial">?</span>
            </div>
        </div>
    </nav>

    <div id="bac-banner" class="hidden animate-pulse">
        <div class="bg-red-500/10 border-b border-red-500/20 px-6 py-2 flex items-center gap-3">
            <span class="flex h-2 w-2 rounded-full bg-red-500"></span>
            <p class="text-[11px] font-bold text-red-400 uppercase tracking-widest">
                Security Warning: Unauthorized Group Access Detected
            </p>
        </div>
    </div>

    <div id="chat-box" class="flex-1 overflow-y-auto px-6 py-8 space-y-6 max-w-4xl w-full mx-auto custom-scrollbar" style="height: calc(100vh - 160px)">
        <div class="flex justify-center">
            <span class="px-4 py-1 rounded-full bg-white/5 border border-white/5 text-[10px] text-gray-500 uppercase tracking-[0.2em]">Memuat riwayat pesan...</span>
        </div>
    </div>

    <div class="bg-[#0f172a] border-t border-white/5 px-6 py-6 backdrop-blur-lg">
        <div class="max-w-4xl mx-auto">
            <div class="relative flex items-center gap-3 bg-[#1e293b]/50 p-2 rounded-2xl border border-white/10 focus-within:border-blue-500/50 transition-all shadow-2xl">
                <input id="msg-input" type="text" placeholder="Ketik pesan strategi..."
                    onkeydown="if(event.key==='Enter') sendMessage()"
                    class="flex-1 bg-transparent border-none rounded-xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-0">

                <button onclick="sendMessage()"
                    class="bg-blue-600 hover:bg-blue-500 text-white p-3 rounded-xl transition-all transform active:scale-95 shadow-lg shadow-blue-500/20 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform rotate-90 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #3b82f6; }
    .bubble-me {
        @apply bg-blue-600 text-white rounded-2xl rounded-tr-none shadow-lg shadow-blue-600/10;
    }
    .bubble-them {
        @apply bg-[#1e293b] text-gray-200 rounded-2xl rounded-tl-none border border-white/5;
    }
</style>

<script>
const token   = localStorage.getItem('token');
const user    = JSON.parse(localStorage.getItem('user') || '{}');
const groupId = window.location.pathname.split('/')[2];

if (!token) window.location.href = '/login';

document.getElementById('user-name').textContent = user.name;
document.getElementById('user-role').textContent  = user.role;

async function loadGroupInfo() {
    const res  = await fetch(`/api/groups/${groupId}`, {
        headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
    });
    const json = await res.json();

    document.getElementById('group-name').textContent = json.data.name;

    const isMember = json.data.member.some(m => m.id === user.id);
    if (!isMember) {
        document.getElementById('bac-banner').classList.remove('hidden');
    }
}

async function loadMessages() {
    const res  = await fetch(`/api/groups/${groupId}/messages`, {
        headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
    });
    const json = await res.json();
    const box  = document.getElementById('chat-box');

    if (!json.data || json.data.length === 0) {
        box.innerHTML = '<div class="text-center text-xs text-gray-400">Belum ada pesan</div>';
        return;
    }

    box.innerHTML = json.data.reverse().map(m => {
        const isMe = m.user_id === user.id;
        return `
            <div class="flex ${isMe ? 'justify-end' : 'justify-start'}">
                <div class="max-w-xs lg:max-w-md">
                   ${!isMe ? `<p class="text-xs text-gray-400 mb-1 ml-1">${m.user ? m.user.name : 'Unknown User'}</p>` : ''}
                    <div class="px-4 py-2 rounded-2xl text-sm
                        ${isMe ? 'bg-blue-600 text-white rounded-br-none' : 'bg-gray-100 text-gray-800 rounded-bl-none'}">
                        ${m.message}
                    </div>
                    <p class="text-xs text-gray-300 mt-1 ${isMe ? 'text-right' : 'text-left'}">
                        ${new Date(m.created_at).toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'})}
                    </p>
                </div>
            </div>`;
    }).join('');

    box.scrollTop = box.scrollHeight;
}

async function sendMessage() {
    const input   = document.getElementById('msg-input');
    const message = input.value.trim();

    if (!message) return;

    input.value = '';

    await fetch(`/api/groups/${groupId}/messages`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + token,
        },
        body: JSON.stringify({ message }),
    });

    loadMessages();
}

loadGroupInfo();
loadMessages();
setInterval(loadMessages, 3000);
</script>
@endsection
