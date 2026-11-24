@extends('layouts.base')

@section('body')
<div class="min-h-screen flex bg-neutral-950 text-neutral-100" x-data="{ sidebarOpen: false }">

    <!-- Sidebar Navigation -->
    <aside class="fixed inset-y-0 left-0 z-40 w-64 bg-neutral-900/90 border-r border-neutral-800 flex flex-col transition-transform duration-200 md:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

        <!-- Business Brand & Header -->
        <div class="h-16 px-5 border-b border-neutral-800 flex items-center justify-between">
            <div class="flex items-center space-x-3 overflow-hidden">
                <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-neutral-950 font-bold text-base flex-shrink-0">
                    C
                </div>
                <div class="truncate">
                    <div class="font-bold text-sm tracking-tight text-white leading-tight">CurtissTax</div>
                    <div class="text-xs text-neutral-400 truncate">{{ $currentBusiness->name ?? 'Business' }}</div>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="md:hidden text-neutral-400 hover:text-white">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto text-sm">
            <a href="{{ route('app.dashboard') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('app.dashboard') ? 'bg-neutral-800 text-white font-semibold' : 'text-neutral-400 hover:text-white hover:bg-neutral-850' }}">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                <span>{{ __('app.nav_dashboard') }}</span>
            </a>

            <a href="{{ route('app.settings.index') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('app.settings.*') ? 'bg-neutral-800 text-white font-semibold' : 'text-neutral-400 hover:text-white hover:bg-neutral-850' }}">
                <i data-lucide="building-2" class="w-4 h-4"></i>
                <span>{{ __('app.nav_settings') }}</span>
            </a>

            <a href="{{ route('app.team.index') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('app.team.*') ? 'bg-neutral-800 text-white font-semibold' : 'text-neutral-400 hover:text-white hover:bg-neutral-850' }}">
                <i data-lucide="users" class="w-4 h-4"></i>
                <span>{{ __('app.nav_team') }}</span>
            </a>

            <a href="{{ route('app.subscription.index') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('app.subscription.*') ? 'bg-neutral-800 text-white font-semibold' : 'text-neutral-400 hover:text-white hover:bg-neutral-850' }}">
                <i data-lucide="credit-card" class="w-4 h-4"></i>
                <span>{{ __('app.nav_subscription') }}</span>
            </a>

            <a href="{{ route('app.audit-logs.index') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('app.audit-logs.*') ? 'bg-neutral-800 text-white font-semibold' : 'text-neutral-400 hover:text-white hover:bg-neutral-850' }}">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
                <span>{{ __('app.nav_audit_logs') }}</span>
            </a>

            @if(auth()->user()->is_super_admin)
                <div class="pt-4 mt-4 border-t border-neutral-800">
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center space-x-3 px-3 py-2 rounded-lg text-amber-400 hover:bg-neutral-800 font-medium transition">
                        <i data-lucide="shield-alert" class="w-4 h-4"></i>
                        <span>{{ __('app.nav_admin') }}</span>
                    </a>
                </div>
            @endif
        </nav>

        <!-- Current User Profile Footer -->
        <div class="p-3 border-t border-neutral-800 bg-neutral-900/60">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 overflow-hidden">
                    <div class="w-8 h-8 rounded-full bg-neutral-800 border border-neutral-700 flex items-center justify-center text-xs font-semibold text-white flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="truncate">
                        <div class="text-xs font-medium text-white truncate">{{ auth()->user()->name }}</div>
                        <div class="text-[11px] text-neutral-400 truncate">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="{{ __('app.nav_logout') }}" class="p-1.5 rounded-md text-neutral-400 hover:text-white hover:bg-neutral-800 transition">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Layout Container -->
    <div class="flex-1 flex flex-col md:pl-64 min-w-0">

        <!-- Top Header Bar -->
        <header class="h-16 border-b border-neutral-800 bg-neutral-950/90 backdrop-blur sticky top-0 z-30 px-4 sm:px-6 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <button @click="sidebarOpen = true" class="md:hidden text-neutral-400 hover:text-white p-1">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div class="flex items-center space-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wider text-neutral-400">
                        @if($currentBusiness->is_vat_registered)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-emerald-950 text-emerald-400 border border-emerald-800/60">
                                VAT Registered
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-neutral-800 text-neutral-300 border border-neutral-700">
                                Non-VAT Entity
                            </span>
                        @endif
                    </span>
                    <span class="text-xs text-neutral-500 hidden sm:inline">|</span>
                    <span class="text-xs text-neutral-400 hidden sm:inline">TIN: <strong class="text-neutral-200">{{ $currentBusiness->tin ?: 'Pending' }}</strong></span>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <!-- 14-Day Free Trial Indicator Pill -->
                @if($currentBusiness->isTrialActive())
                    <a href="{{ route('app.subscription.index') }}"
                       class="hidden sm:inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-950/60 text-amber-300 border border-amber-800/60 hover:bg-amber-900/60 transition">
                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                        <span>{{ __('app.trial_active_badge', ['days' => $currentBusiness->daysRemainingInTrial()]) }}</span>
                    </a>
                @elseif($currentBusiness->isTrialExpired() && !$currentBusiness->hasActiveSubscription())
                    <a href="{{ route('app.subscription.index') }}"
                       class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-950/70 text-red-400 border border-red-800/80 animate-pulse">
                        <i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i>
                        <span>{{ __('app.subscription_expired_title') }}</span>
                    </a>
                @endif

                <!-- Language Switcher -->
                @include('components.language-selector')
            </div>
        </header>

        <!-- Trial or Expired Alert Banner -->
        @include('components.trial-banner')

        <!-- Page Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-lg bg-emerald-950/60 border border-emerald-800/80 text-emerald-300 text-sm flex items-center space-x-3">
                    <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-lg bg-red-950/60 border border-red-800/80 text-red-300 text-sm flex items-center space-x-3">
                    <i data-lucide="alert-octagon" class="w-5 h-5 flex-shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
@endsection
