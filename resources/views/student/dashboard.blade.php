<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - SmartForum</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    <div class="flex min-h-screen">
        
        <aside class="fixed inset-y-0 left-0 w-64 border-r bg-white p-6 flex flex-col justify-between shadow-sm">
            <div class="space-y-6">
                <h2 class="text-xl font-bold text-indigo-600 tracking-tight">SmartForum</h2>
                <nav class="space-y-1 flex flex-col">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-semibold text-sm flex items-center gap-2">
                        <span>📊</span> Dashboard Portal
                    </a>
                    <a href="#discussion-section" class="px-4 py-2.5 text-slate-600 hover:bg-slate-50 rounded-xl text-sm flex items-center gap-2 transition">
                        <span>🗣️</span> Discussion Forums
                    </a>
                    <a href="#quiz-section" class="px-4 py-2.5 text-slate-600 hover:bg-slate-50 rounded-xl text-sm flex items-center gap-2 transition">
                        <span>📝</span> My Quizzes
                    </a>
                    <a href="{{ route('profile.edit') }}" class="px-4 py-2.5 text-slate-600 hover:bg-slate-50 rounded-xl text-sm flex items-center gap-2 transition">
                        <span>⚙️</span> Account Profile
                    </a>
                </nav>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-sm transition text-sm cursor-pointer">
                    Logout
                </button>
            </form>
        </aside>

        <div class="flex-1 pl-64">
            <header class="h-16 border-b border-slate-200 bg-white sticky top-0 z-10 px-8 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-slate-400 font-medium text-sm">Welcome back,</span>
                    <h1 class="text-sm font-extrabold text-slate-900">{{ Auth::user()->name }} 🧑‍🎓</h1>
                </div>
                <div class="flex items-center gap-3">
                    @if(Auth::user()->group)
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-blue-50 text-blue-600">Registered Group: {{ Auth::user()->group->name }}</span>
                    @else
                        <button onclick="openModal('selectGroupModal')" class="text-xs font-bold px-3 py-1 rounded-full bg-red-50 text-red-600 animate-pulse border border-red-200">⚠️ Click to Select Class Group</button>
                    @endif
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-indigo-50 text-indigo-600">Student Mode</span>
                </div>
            </header>

            <main class="p-8 max-w-5xl mx-auto space-y-6">
                
                @if(!Auth::user()->group_id)
                    <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-sm font-medium shadow-sm">
                        <strong>Enrollment Required:</strong> You must select an academic group using the button in the upper header panel to access and view your group's customized discussion streams or quizzes.
                    </div>
                @endif

                @if(Auth::user()->status === 'restricted')
                    <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-sm font-medium shadow-sm flex items-center gap-2">
                        <span>⚠️</span>
                        <div>
                            <strong>Account Restrained:</strong> An administrator has temporarily suspended your submission privileges. You can read discussions, but posting topics, writing replies, and quiz attempts are frozen.
                        </div>
                    </div>
                @endif

                @if(str_contains(Auth::user()->status ?? '', 'warning'))
                    <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm font-medium shadow-sm flex items-center gap-2">
                        <span>🚨</span>
                        <div>
                            <strong>Policy Infraction Advisory:</strong> You have an active warning logged against your account file (Current warnings: {{ Auth::user()->warnings_count ?? 0 }}/3). Reaching a third warning triggers an automatic system blacklist block.
                        </div>
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="p-4 text-sm text-green-800 bg-green-50 border border-green-200 rounded-xl shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm">
                            <h4 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">📢 Broadcast Notices</h4>
                            <div class="space-y-3">
                                @forelse($announcements as $notice)
                                    <div class="p-4 border border-slate-100 bg-slate-50/40 rounded-xl">
                                        <h5 class="text-xs font-bold text-slate-900">{{ $notice->title }}</h5>
                                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ $notice->content }}</p>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 italic">No broadcast notices published for your group yet.</p>
                                @endforelse
                            </div>
                        </div>

                        <div id="discussion-section" class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm">
                            <h4 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">🗣️ Active Discussion Streams</h4>
                            <div class="space-y-3">
                                @forelse($topics as $topic)
                                    <div class="p-4 border border-slate-100 bg-slate-50/40 rounded-xl flex justify-between items-center gap-4">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h5 class="text-xs font-bold text-slate-900">{{ $topic->title }}</h5>
                                                @if($topic->is_resolved)
                                                    <span class="px-2 py-0.5 text-[9px] font-extrabold bg-green-100 text-green-700 rounded-full">✓ Resolved</span>
                                                @endif
                                            </div>
                                            <span class="text-[10px] text-slate-400 font-medium block mt-0.5">👁️ {{ $topic->views_count }} views</span>
                                        </div>
                                        <a href="{{ route('forum.show', $topic->id) }}" class="px-3 py-1.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition whitespace-nowrap">Join Discussion</a>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 italic">No active group streams available right now.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm">
                            <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">💡 Unresolved Questions Feed</h4>
                            <div class="space-y-2">
                                @forelse($unansweredQuestions as $q)
                                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex justify-between items-center">
                                        <span class="text-xs font-bold text-slate-700 truncate max-w-[70%]">{{ $q->title }}</span>
                                        <a href="{{ route('forum.show', $q->id) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition whitespace-nowrap">Help Answer ➡️</a>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 italic">All group questions have been resolved!</p>
                                @endforelse
                            </div>
                        </div>

                    </div>

                    <div id="quiz-section" class="space-y-6">
                        <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm">
                            <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">📝 Deployed Evaluation Quizzes</h4>
                            <div class="space-y-3">
                                @forelse($quizzes as $quiz)
                                    <div class="p-4 bg-red-50/30 border-l-4 border-red-500 rounded-r-xl border-y border-r border-slate-100">
                                        <h5 class="text-xs font-bold text-slate-900">{{ $quiz->title }}</h5>
                                        <div class="flex items-center justify-between mt-3">
                                            <span class="text-[10px] font-bold text-slate-500">⏱️ {{ $quiz->duration_minutes }} Mins</span>
                                            @if(Auth::user()->status === 'restricted')
                                                <button disabled class="px-3 py-1 text-xs font-bold text-slate-400 bg-slate-200 rounded-lg cursor-not-allowed">Locked</button>
                                            @else
                                                <a href="{{ route('quiz.show', $quiz->id) }}" class="px-3 py-1 text-xs font-bold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-sm transition">Start Quiz</a>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 italic">No custom quizzes deployed to your group yet.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <div id="selectGroupModal" class="hidden fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl relative">
            <h3 class="text-base font-bold text-slate-900 mb-2">Select Academic Cohort</h3>
            <form action="{{ route('profile.updateGroup') }}" method="POST">
                @csrf @method('PATCH')
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Choose Group Connection</label>
                        <select name="group_id" required class="w-full px-3 py-2 border rounded-xl text-sm outline-none bg-white">
                            @foreach($allGroups as $g)
                                <option value="{{ $g->id }}">{{ $g->name }} [{{ $g->code }}]</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('selectGroupModal')" class="px-4 py-2 text-sm text-slate-500 hover:bg-slate-50 rounded-xl">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-sm">Join Cohort</button>
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