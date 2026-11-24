@extends('layouts.public')

@section('title', __('auth.reset_password_title') . ' – ' . __('app.brand'))

@section('content')
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-6 bg-neutral-900 border border-neutral-800 p-8 rounded-2xl">
        <div class="text-center space-y-2">
            <h2 class="text-2xl font-bold tracking-tight text-white">{{ __('auth.reset_password_title') }}</h2>
            <p class="text-xs text-neutral-400">Enter your email and we'll send you a password reset link.</p>
        </div>

        <form class="space-y-4" action="#" method="POST">
            @csrf
            <div>
                <label for="email" class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('auth.email_label') }}</label>
                <input id="email" name="email" type="email" required
                       class="w-full px-3.5 py-2.5 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none"
                       placeholder="you@company.lk">
            </div>

            <button type="button"
                    class="w-full py-2.5 px-4 rounded-lg bg-white text-neutral-950 font-semibold text-xs hover:bg-neutral-200 transition">
                {{ __('auth.reset_password_btn') }}
            </button>

            <div class="text-center text-xs">
                <a href="{{ route('login') }}" class="text-neutral-400 hover:text-white">{{ __('auth.back_to_login') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
