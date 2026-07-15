<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartForum - Share Knowledge, Grow Together</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">

    <header class="h-20 bg-white border-b border-slate-100 px-8 flex items-center justify-between sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-2">
            <span class="text-2xl">💡</span>
            <span class="font-extrabold text-xl tracking-tight text-indigo-600">SmartForum</span>
        </div>
        
        <nav class="flex items-center gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition">
                            Register Account
                        </a>
                    @endif
                @endauth
            @endif
        </nav>
    </header>

    <main class="relative bg-gradient-to-r from-indigo-600 to-violet-700 text-white py-24 px-8 text-center overflow-hidden">
        <div class="max-w-4xl mx-auto relative z-10 space-y-6">
            <h1 class="text-4xl md:text-6xl font-black tracking-tight leading-tight">
                Share Knowledge, <br class="hidden sm:inline">Grow Together
            </h1>
            <p class="text-indigo-100 text-base md:text-lg max-w-2xl mx-auto leading-relaxed font-medium">
                Welcome to the Smart Discussion Forum. Connect with expert minds, ask academic questions, and explore creative engineering ideas.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
                <a href="#" class="px-6 py-3 font-bold bg-white text-indigo-600 hover:bg-slate-50 rounded-xl shadow-md transition">
                    Browse Discussions
                </a>
                <a href="#" class="px-6 py-3 font-bold bg-indigo-500 hover:bg-indigo-400 text-white border border-indigo-400 rounded-xl shadow-md transition">
                    Start a Topic
                </a>
            </div>
        </div>
        
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
    </main>

</body>
</html>