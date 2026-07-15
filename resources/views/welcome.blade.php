<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Discussion Forum - Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased flex flex-col min-h-screen justify-center items-center p-4">

    <div class="max-w-md w-full bg-white border border-slate-200 p-8 rounded-3xl shadow-sm text-center space-y-6">
        
        <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-600 text-white text-2xl font-black shadow-sm mx-auto">
            S
        </div>

        <div class="space-y-2">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Smart Discussion Forum</h1>
            <p class="text-xs text-slate-500 max-w-xs mx-auto leading-relaxed">
                Welcome to your campus digital gateway interface. Connect to active learning streams, complete evaluation quizzes, and track announcements.
            </p>
        </div>

        <div class="border-t border-slate-100 pt-6 flex flex-col gap-2">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full py-2.5 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition">
                        Enter Workspace Portal ➡️
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full py-2.5 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition">
                        Log In Securely
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="w-full py-2.5 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                            Create an Account
                        </a>
                    @endif
                @endauth
            @endif
        </div>
        
    </div>

    <footer class="mt-8 text-[10px] font-medium text-slate-400 tracking-wide">
        &copy; 2026 SmartForum LMS Environment. All rights reserved.
    </footer>

</body>
</html>