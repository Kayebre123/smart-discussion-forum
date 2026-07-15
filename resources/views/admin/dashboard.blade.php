<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin System Console - SmartForum</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    <div class="flex min-h-screen">
        
        <aside class="fixed inset-y-0 left-0 w-64 border-r bg-white p-6 flex flex-col justify-between shadow-sm">
            <div class="space-y-6">
                <h2 class="text-xl font-bold text-red-600 tracking-tight">SmartForum Admin</h2>
                <nav class="space-y-2 flex flex-col">
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-red-50 text-red-600 rounded-xl font-semibold text-sm">
                        🖥️ Control Console
                    </a>
                    <button onclick="openModal('groupModal')" class="text-left px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 rounded-xl transition cursor-pointer">
                        ➕ Provision Group
                    </button>
                    <a href="{{ route('profile.edit') }}" class="px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 rounded-xl transition flex items-center gap-2">
                        ⚙️ Global Settings
                    </a>
                </nav>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-sm text-sm transition cursor-pointer">
                    Logout
                </button>
            </form>
        </aside>

        <div class="flex-1 pl-64">
            <header class="h-16 border-b border-slate-200 bg-white sticky top-0 z-10 px-8 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-slate-400 font-medium text-sm">Active Administrator:</span>
                    <h1 class="text-sm font-extrabold text-slate-900">{{ Auth::user()->name }} 🛡️</h1>
                </div>
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-red-50 text-red-600">Root Infrastructure Mode</span>
            </header>

            <main class="p-8 max-w-5xl mx-auto space-y-6">
                
                <div class="p-6 bg-gradient-to-r from-slate-900 to-indigo-950 text-white rounded-2xl shadow-sm">
                    <span class="text-[10px] uppercase font-bold text-indigo-400 tracking-wider block mb-1">Realtime Operational Control</span>
                    <h2 class="text-xl font-extrabold tracking-tight">System Synchronicity Console</h2>
                    <p class="text-xs text-slate-300 mt-1 max-w-2xl leading-relaxed">Connected to active database matrices. Warning issuance thresholds automatically assign restricted user flags visibility layers instantly across student and lecturer workspaces.</p>
                </div>

                @if(session('success'))
                    <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm font-medium shadow-sm">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Total Accounts</span>
                        <p class="text-xl font-extrabold text-slate-900 mt-1">{{ $metrics['total_accounts'] ?? 0 }}</p>
                    </div>
                    <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Active Logs</span>
                        <p class="text-xl font-extrabold text-green-600 mt-1">{{ $metrics['active_users'] ?? 0 }}</p>
                    </div>
                    <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Groups</span>
                        <p class="text-xl font-extrabold text-blue-600 mt-1">{{ $groups->count() }}</p>
                    </div>
                    <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Flagged Warnings</span>
                        <p class="text-xl font-extrabold text-red-500 mt-1">{{ $metrics['flagged_warnings'] ?? 0 }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <button onclick="openModal('groupModal')" class="p-6 bg-red-600 text-white font-bold rounded-2xl shadow-sm hover:bg-red-700 transition flex items-center justify-between text-left cursor-pointer">
                        <span>👥 Provision New Academic Group Matrix</span>
                        <span class="text-xl">➡️</span>
                    </button>
                    <a href="#matrix-section" class="p-6 bg-slate-800 text-white font-bold rounded-2xl shadow-sm hover:bg-slate-900 transition flex items-center justify-between text-left">
                        <span>📊 View Shared Structural Cohorts</span>
                        <span class="text-xl">⬇️</span>
                    </a>
                </div>

                <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm">
                    <h3 class="text-sm font-bold text-slate-900 mb-4">User Accounts & Performance Control Matrix</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="border-b border-slate-100 text-slate-400 font-bold bg-slate-50/70">
                                    <th class="p-3">User Identity</th>
                                    <th class="p-3">Role</th>
                                    <th class="p-3">Status / Flags</th>
                                    <th class="p-3 text-center">Warnings Count</th>
                                    <th class="p-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                                @forelse($users as $user)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="p-3">
                                            <div class="font-bold text-slate-900">{{ $user->name }}</div>
                                            <div class="text-[10px] text-slate-400 font-normal">{{ $user->email }}</div>
                                        </td>
                                        <td class="p-3">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $user->role === 'admin' ? 'bg-red-50 text-red-600' : ($user->role === 'lecturer' ? 'bg-purple-50 text-purple-600' : 'bg-blue-50 text-blue-600') }}">
                                                {{ $user->role }}
                                            </span>
                                        </td>
                                        <td class="p-3">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $user->status === 'active' ? 'bg-green-50 text-green-600' : 'bg-amber-50 text-amber-600' }}">
                                                {{ ucfirst($user->status ?? 'Active') }}
                                            </span>
                                        </td>
                                        <td class="p-3 text-center font-bold text-red-600">{{ $user->warnings_count ?? 0 }}</td>
                                        <td class="p-3 flex items-center justify-center gap-1.5">
                                            <form action="{{ route('admin.user.warn', $user->id) }}" method="POST" class="inline m-0">
                                                @csrf
                                                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-bold text-[10px] px-2 py-1 rounded cursor-pointer">⚠️ Warn</button>
                                            </form>
                                            <form action="{{ route('admin.user.restrict', $user->id) }}" method="POST" class="inline m-0">
                                                @csrf
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold text-[10px] px-2 py-1 rounded cursor-pointer">🚫 Restrict</button>
                                            </form>
                                            <form action="{{ route('admin.user.activate', $user->id) }}" method="POST" class="inline m-0">
                                                @csrf
                                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold text-[10px] px-2 py-1 rounded cursor-pointer">✓ Activate</button>
                                            </form>
                                            <form action="{{ route('admin.user.reset-warnings', $user->id) }}" method="POST" class="inline m-0">
                                                @csrf
                                                <button type="submit" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-[10px] px-2 py-1 rounded cursor-pointer">🔄 Reset</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-4 text-center text-slate-400 italic">No alternative user system profiles found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="matrix-section" class="space-y-6 pt-6">
                    <hr class="border-slate-200">
                    <h3 class="text-sm font-bold text-slate-900">Academic Groups Structural Matrix</h3>
                    
                    @forelse($groups as $group)
                        <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm space-y-4">
                            <div class="flex justify-between items-center border-b pb-3">
                                <h4 class="text-sm font-bold text-indigo-600">Class Group: {{ $group->name }}</h4>
                                <span class="text-[10px] bg-slate-100 px-2 py-0.5 rounded text-slate-500 font-semibold">Code: {{ $group->code }}</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                                <div class="bg-slate-50/60 p-3 rounded-xl border border-slate-100">
                                    <span class="font-bold text-slate-500 uppercase tracking-wider text-[9px] block mb-2">Assigned Lecturers</span>
                                    <div class="space-y-2">
                                        @forelse($group->users->where('role', 'lecturer') as $lecturer)
                                            <div class="flex justify-between items-center">
                                                <span class="font-bold text-slate-800">{{ $lecturer->name }}</span>
                                                <span class="text-[10px] text-slate-400">{{ $lecturer->email }}</span>
                                            </div>
                                        @empty
                                            <p class="italic text-slate-400 text-[11px]">No lecturers joined this cohort yet.</p>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="bg-slate-50/60 p-3 rounded-xl border border-slate-100">
                                    <span class="font-bold text-slate-500 uppercase tracking-wider text-[9px] block mb-2">Registered Students</span>
                                    <div class="space-y-2">
                                        @forelse($group->users->where('role', 'student') as $student)
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <span class="font-bold text-slate-800 block">{{ $student->name }}</span>
                                                    <span class="text-[9px] text-slate-400">{{ $student->email }}</span>
                                                </div>
                                                <span class="px-2 py-0.5 text-[9px] font-bold rounded {{ $student->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                                    {{ ucfirst($student->status) }}
                                                </span>
                                            </div>
                                        @empty
                                            <p class="italic text-slate-400 text-[11px]">No students enrolled in this group yet.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 bg-white border border-slate-200 rounded-2xl text-center text-slate-400 italic text-xs">
                            No academic groups defined yet. Use the control menu to configure matrices.
                        </div>
                    @endforelse
                </div>
            </main>
        </div>
    </div>

    <div id="groupModal" class="hidden fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl relative">
            <h3 class="text-base font-bold text-slate-900 mb-4">Provision New Group Registry</h3>
            <form action="{{ route('admin.storeGroup') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Group Name / Descriptor</label>
                        <input type="text" name="name" placeholder="e.g. Computer Science 2026" required class="w-full px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-red-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Unique Group Access Code</label>
                        <input type="text" name="code" placeholder="e.g. CS-2026" required class="w-full px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-red-500 outline-none">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('groupModal')" class="px-4 py-2 text-sm text-slate-500 hover:bg-slate-50 rounded-xl transition cursor-pointer">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-bold shadow-sm transition cursor-pointer">Deploy Matrix</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    </script>
</body>
</html>