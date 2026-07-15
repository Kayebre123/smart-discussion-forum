<x-guest-layout>
    <div class="w-full max-w-md rounded-3xl border border-slate-200 bg-white/95 p-8 shadow-2xl shadow-slate-200/70 backdrop-blur">
        <div class="mb-6 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-indigo-700">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <h2 class="mt-4 text-2xl font-semibold text-slate-900">Academic Portal Sign In</h2>
            <p class="mt-2 text-sm text-slate-600">Access your Smart Discussion Forum workspace securely.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        @if ($errors->any())
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700" role="alert">
                <p class="font-semibold">We could not sign you in.</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <div class="mt-3 flex flex-wrap gap-3 text-sm">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="font-medium text-red-700 underline decoration-2 underline-offset-2">Create an account</a>
                    @endif
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="font-medium text-red-700 underline decoration-2 underline-offset-2">Reset password</a>
                    @endif
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                <label for="agree_terms" class="flex items-start gap-3 text-sm text-slate-700">
                    <input id="agree_terms" type="checkbox" name="agree_terms" value="1" required class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span>I agree to the platform Terms and Conditions.</span>
                </label>
            </div>

            <div class="flex items-center justify-between pt-2">
                <label for="remember_me" class="inline-flex items-center text-sm text-slate-600">
                    <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-indigo-600 underline decoration-2 underline-offset-2" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <x-primary-button class="mt-2 w-full justify-center">
                {{ __('Sign in') }}
            </x-primary-button>
        </form>
    </div>
</x-guest-layout>
