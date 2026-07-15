<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Smart Discussion Forum</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-950 text-slate-100">
        <div class="mx-auto flex min-h-screen max-w-7xl flex-col px-6 py-8 lg:px-10">
            <header class="mb-10 flex flex-col gap-4 rounded-3xl border border-white/10 bg-white/5 px-5 py-4 backdrop-blur sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.35em] text-sky-300">Smart Discussion Forum</p>
                    <p class="text-sm text-slate-400">A calm, academic space for discussion and mentorship</p>
                </div>
                <nav class="flex items-center gap-3 text-sm">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-full border border-sky-400/40 bg-sky-500/10 px-4 py-2 font-medium text-sky-200 transition hover:bg-sky-500/20">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-full border border-white/10 px-4 py-2 text-slate-200 transition hover:border-sky-400/40 hover:text-sky-200">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-full bg-sky-500 px-4 py-2 font-semibold text-slate-950 transition hover:bg-sky-400">Register</a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </header>

            <main class="grid flex-1 items-center gap-10 lg:grid-cols-[1.1fr_0.9fr]">
                <section class="max-w-2xl">
                    <span class="inline-flex rounded-full border border-sky-400/30 bg-sky-500/10 px-3 py-1 text-sm font-medium text-sky-300">Academic community platform</span>
                    <h1 class="mt-6 text-4xl font-semibold tracking-tight text-white sm:text-5xl">Bring students, lecturers, and admins into one focused learning space.</h1>
                    <p class="mt-5 text-lg leading-8 text-slate-300">Smart Discussion Forum helps institutions host thoughtful conversations, share updates, and guide participation with clear moderation and role-based dashboards.</p>
                    <div class="mt-8 flex flex-wrap gap-4">
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="rounded-full bg-white px-6 py-3 font-semibold text-slate-950 transition hover:bg-slate-200">Open the portal</a>
                        @endif
                        <a href="{{ url('/register') }}" class="rounded-full border border-white/15 px-6 py-3 font-semibold text-slate-100 transition hover:border-sky-400/40 hover:text-sky-200">Create an account</a>
                    </div>
                    <div class="mt-10 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-2xl font-semibold text-white">24/7</p>
                            <p class="mt-1 text-sm text-slate-400">Student discussion threads</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-2xl font-semibold text-white">Role-aware</p>
                            <p class="mt-1 text-sm text-slate-400">Dashboards for admins and lecturers</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-2xl font-semibold text-white">Secure</p>
                            <p class="mt-1 text-sm text-slate-400">Clear moderation and access control</p>
                        </div>
                    </div>
                </section>

                <section class="rounded-3xl border border-white/10 bg-gradient-to-br from-slate-900 via-slate-900 to-sky-950 p-8 shadow-2xl shadow-sky-950/40">
                    <div class="rounded-2xl border border-sky-400/20 bg-slate-950/70 p-6">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-300">Why it stands out</p>
                        <ul class="mt-5 space-y-4 text-sm text-slate-300">
                            <li class="flex gap-3"><span class="mt-1 h-2.5 w-2.5 rounded-full bg-sky-400"></span><span>Structured channels for classes, groups, and campus updates.</span></li>
                            <li class="flex gap-3"><span class="mt-1 h-2.5 w-2.5 rounded-full bg-sky-400"></span><span>Fast moderation tools for warning, suspension, and safe review.</span></li>
                            <li class="flex gap-3"><span class="mt-1 h-2.5 w-2.5 rounded-full bg-sky-400"></span><span>Elegant dashboards that keep each role focused and productive.</span></li>
                        </ul>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
