@extends('layouts.public')

@section('title', __('auth.login_title') . ' – ' . __('app.brand'))

@section('content')
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-neutral-900/90 border border-neutral-800 p-8 rounded-2xl shadow-2xl">
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-white text-neutral-950 font-bold text-xl mb-2">
                C
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-white">{{ __('auth.login_title') }}</h2>
            <p class="text-xs text-neutral-400">
                {{ __('auth.no_account') }}
                <a href="{{ route('register') }}" class="font-medium text-white hover:underline">{{ __('app.nav_register') }}</a>
            </p>
        </div>

        @if ($errors->any())
            <div class="p-3.5 rounded-lg bg-red-950/70 border border-red-800 text-red-300 text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <div class="flex items-center space-x-2">
                        <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <form class="space-y-4" action="{{ route('login') }}" method="POST">
            @csrf
            <div>
                <label for="email" class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('auth.email_label') }}</label>
                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                       class="w-full px-3.5 py-2.5 rounded-lg bg-neutral-950 border border-neutral-800 text-white placeholder-neutral-500 text-xs focus:outline-none focus:ring-2 focus:ring-neutral-700 transition"
                       placeholder="you@company.lk">
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-medium text-neutral-300">{{ __('auth.password_label') }}</label>
                    <a href="{{ route('password.request') }}" class="text-[11px] text-neutral-400 hover:text-white">{{ __('auth.forgot_password') }}</a>
                </div>
                <input id="password" name="password" type="password" autocomplete="current-password" required
                       class="w-full px-3.5 py-2.5 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:outline-none focus:ring-2 focus:ring-neutral-700 transition">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center space-x-2 cursor-pointer text-neutral-400 hover:text-neutral-300">
                    <input type="checkbox" name="remember" class="rounded bg-neutral-950 border-neutral-800 text-white focus:ring-neutral-700">
                    <span>{{ __('auth.remember_me') }}</span>
                </label>
            </div>

            <button type="submit"
                    class="w-full py-2.5 px-4 rounded-lg bg-white text-neutral-950 font-semibold text-xs hover:bg-neutral-200 transition shadow-sm">
                {{ __('auth.sign_in_button') }}
            </button>
        </form>

        <div class="pt-4 border-t border-neutral-800/80 text-center text-[11px] text-neutral-500">
            Demo credentials: <code class="text-neutral-300">demo@curtisstax.com</code> / <code class="text-neutral-300">Demo@123456</code>
        </div>
    </div>
</div>
@endsection
