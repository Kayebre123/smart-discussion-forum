<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Smart Discussion Forum</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased">

    <div class="flex min-h-screen">
        
        <aside class="fixed inset-y-0 left-0 z-20 w-64 border-r border-slate-200 bg-white flex flex-col justify-between shadow-sm">
            <div class="flex-1 overflow-y-auto">
                <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-100">
                    <div class="h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 flex text-white font-bold text-lg">
                        S
                    </div>
                    <span class="font-bold text-lg text-slate-900 tracking-tight">SmartForum</span>
                </div>

                <nav class="mt-4 px-3 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-indigo-600 bg-indigo-50/70 rounded-xl">
                        <span>📊</span> Dashboard
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition">
                        <span>💬</span> Topics
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition">
                        <span>➕</span> Create Topic
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition">
                        <span>👥</span> Discussion Forum
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition">
                        <span>✉️</span> Messages
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition">
                        <span>📢</span> Announcements
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition">
                        <span>📝</span> Quiz
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition">
                        <span>⭐</span> Participation Marks
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition">
                        <span>🤖</span> AI Recommendations
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition">
                        <span>📄</span> Export Discussion PDF
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition">
                        <span>⚙️</span> Profile
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-slate-100 bg-white shrink-0">
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-xl shadow-sm transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 pl-64">
            
            <header class="h-16 border-b border-slate-200 bg-white sticky top-0 z-10 px-8 flex items-center justify-between">
                <h1 class="text-xl font-bold text-slate-900">Dashboard Overview</h1>
                
                <div class="flex items-center gap-6">
                    <div class="relative cursor-pointer">
                        <span class="text-xl">🔔</span>
                        <span class="absolute -top-1.5 -right-1.5 h-4 w-4 bg-red-500 text-[10px] font-bold text-white rounded-full flex items-center justify-center">3</span>
                    </div>

                    <div class="flex items-center gap-3 border-l border-slate-200 pl-6">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2563EB&color=fff" alt="User Image" class="h-9 w-9 rounded-full border border-slate-200">
                        <div class="text-left">
                            <p class="text-sm font-bold text-slate-900 leading-none mb-0.5">{{ Auth::user()->name }}</p>
                            <span class="text-xs font-medium text-slate-500">Student Profile</span>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-8 max-w-7xl mx-auto space-y-6">
                
                <div class="p-6 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-sm flex flex-col md:flex-row justify-between md:items-center gap-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-widest text-blue-100 block mb-1">Academic Session active</span>
                        <h2 class="text-2xl font-extrabold mb-1">Hello, {{ Auth::user()->name }}!</h2>
                        <p class="text-blue-100/90 text-sm max-w-2xl leading-relaxed">"The beautiful thing about learning is that no one can take it away from you." Review task streams, check pending reflections, and collaborate with peers.</p>
                    </div>
                    <div class="shrink-0 bg-white/10 border border-white/10 px-4 py-2 rounded-xl text-sm font-medium self-start md:self-auto">
                        📅 {{ now()->format('D, d M Y') }}
                    </div>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="p-5 bg-white border border-slate-200 rounded-2xl shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-medium text-slate-500 block mb-0.5">Participation</span>
                            <h3 class="text-2xl font-bold text-slate-900">88%</h3>
                        </div>
                        <div class="h-10 w-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">⭐</div>
                    </div>
                    <div class="p-5 bg-white border border-slate-200 rounded-2xl shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-medium text-slate-500 block mb-0.5">Current Grade</span>
                            <h3 class="text-2xl font-bold text-green-600">A-</h3>
                        </div>
                        <div class="h-10 w-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-lg">🏆</div>
                    </div>
                    <div class="p-5 bg-white border border-slate-200 rounded-2xl shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-medium text-slate-500 block mb-0.5">Topics / Replies</span>
                            <h3 class="text-2xl font-bold text-slate-900">12 / 44</h3>
                        </div>
                        <div class="h-10 w-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">💬</div>
                    </div>
                    <div class="p-5 bg-white border border-slate-200 rounded-2xl shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-medium text-slate-500 block mb-0.5">Pending Quiz</span>
                            <h3 class="text-2xl font-bold text-slate-900">1 Active</h3>
                        </div>
                        <div class="h-10 w-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">⏱️</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-base font-bold text-slate-900 flex items-center gap-2">📢 Recent Announcements</h4>
                                <a href="#" class="text-xs font-semibold text-blue-600 hover:underline">View All</a>
                            </div>
                            <div class="p-4 bg-amber-50/40 border-l-4 border-amber-500 rounded-r-xl">
                                <div class="flex justify-between items-center mb-1">
                                    <h5 class="text-sm font-bold text-slate-900">Midterm Reflection Guidelines</h5>
                                    <span class="text-xs text-slate-400">2 hours ago</span>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed mb-3">Please ensure your discussion group tables are completely set up by Friday. Participation scores will be parsed at midnight...</p>
                                <button class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition shadow-sm">Read Full Notice</button>
                            </div>
                        </div>

                        <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-base font-bold text-slate-900 flex items-center gap-2">🗣️ Active Forum Streams</h4>
                                <button class="px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition shadow-sm">+ New Topic</button>
                            </div>
                            <div class="p-4 border border-slate-100 bg-slate-50/40 rounded-xl space-y-2">
                                <h5 class="text-sm font-bold text-slate-900">Implications of AI Content Engines in Higher Education Syntax</h5>
                                <p class="text-xs text-slate-500 leading-relaxed">How are we drawing lines between predictive assistive writing software models and standard individual scholarly work outputs?</p>
                                <div class="pt-3 border-t border-slate-100 border-dashed flex flex-wrap items-center justify-between gap-2 text-xs text-slate-400">
                                    <div class="flex gap-3">
                                        <span>💬 24 replies</span>
                                        <span>👁️ 180 views</span>
                                        <span>By <strong class="text-slate-700">Prof. Roberts</strong></span>
                                    </div>
                                    <button class="px-3 py-1.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition shadow-sm">Join Discussion</button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="space-y-6">
                        
                        <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm">
                            <h4 class="text-base font-bold text-slate-900 mb-3 flex items-center gap-2">📝 Upcoming Quiz</h4>
                            <div class="p-4 bg-red-50/40 border-l-4 border-red-500 rounded-r-xl">
                                <h5 class="text-sm font-bold text-slate-900 mb-0.5">Weekly Reflection #4</h5>
                                <p class="text-xs text-slate-400 mb-3">⏰ Opens: Today, 2:00 PM</p>
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-[11px] font-medium text-amber-700 bg-amber-50 px-2 py-1 rounded-md">⌛ 45 mins limit</span>
                                    <button class="px-3 py-1.5 text-xs font-bold text-white bg-red-600 hover:bg-red-700 rounded-lg transition shadow-sm">Start Quiz</button>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm bg-dashed border-dashed bg-slate-50/20">
                            <h4 class="text-base font-bold text-slate-900 mb-1 flex items-center gap-2">🤖 AI Recommendations</h4>
                            <p class="text-xs text-slate-400 mb-3">Based on your activity records in syntax and module code-switching:</p>
                            <div class="p-3 bg-white border border-slate-200 rounded-xl shadow-none">
                                <h6 class="text-xs font-bold text-slate-900 mb-1">Sociology of Language and Identity Codes</h6>
                                <p class="text-[11px] text-slate-400 mb-2">3 cohort peers joined this forum recently.</p>
                                <a href="#" class="text-xs font-bold text-blue-600 hover:underline inline-flex items-center gap-1">Open Discussion →</a>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>