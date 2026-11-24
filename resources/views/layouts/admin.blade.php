@extends('layouts.base')

@section('body')
<div class="min-h-screen flex bg-neutral-950 text-neutral-100" x-data="{ sidebarOpen: false }">

    <!-- Super Admin Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-40 w-64 bg-neutral-900 border-r border-neutral-800 flex flex-col transition-transform duration-200 md:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

        <div class="h-16 px-5 border-b border-neutral-800 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg bg-amber-400 flex items-center justify-center text-neutral-950 font-bold text-base">
                    A
                </div>
                <div>
                    <div class="font-bold text-sm text-white">CurtissTax</div>
                    <div class="text-[11px] font-semibold text-amber-400 uppercase tracking-wider">Super Admin</div>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="md:hidden text-neutral-400 hover:text-white">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1 text-sm overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-neutral-800 text-white font-semibold' : 'text-neutral-400 hover:text-white hover:bg-neutral-850' }}">
                <i data-lucide="layout-grid" class="w-4 h-4"></i>
                <span>{{ __('app.admin_dashboard') }}</span>
            </a>

            <a href="{{ route('admin.businesses.index') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('admin.businesses.*') ? 'bg-neutral-800 text-white font-semibold' : 'text-neutral-400 hover:text-white hover:bg-neutral-850' }}">
                <i data-lucide="building" class="w-4 h-4"></i>
                <span>{{ __('app.admin_businesses') }}</span>
            </a>

            <a href="{{ route('admin.plans.index') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('admin.plans.*') ? 'bg-neutral-800 text-white font-semibold' : 'text-neutral-400 hover:text-white hover:bg-neutral-850' }}">
                <i data-lucide="credit-card" class="w-4 h-4"></i>
                <span>{{ __('app.admin_plans') }}</span>
            </a>

            <div class="pt-4 mt-4 border-t border-neutral-800">
                <a href="{{ route('app.dashboard') }}"
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg text-neutral-400 hover:text-white hover:bg-neutral-800 font-medium transition">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>{{ __('app.nav_dashboard') }}</span>
                </a>
            </div>
        </nav>

        <div class="p-3 border-t border-neutral-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-2 text-xs text-neutral-400 hover:text-white p-2 rounded hover:bg-neutral-800 transition">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    <span>{{ __('app.nav_logout') }}</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Super Admin Main Area -->
    <div class="flex-1 flex flex-col md:pl-64 min-w-0">
        <header class="h-16 border-b border-neutral-800 bg-neutral-950/90 backdrop-blur sticky top-0 z-30 px-4 sm:px-6 flex items-center justify-between">
            <button @click="sidebarOpen = true" class="md:hidden text-neutral-400 hover:text-white p-1">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>
            <div class="flex items-center space-x-2">
                <span class="text-xs font-semibold px-2 py-0.5 rounded bg-amber-950 text-amber-300 border border-amber-800/80">Platform Management</span>
            </div>
            <div class="flex items-center space-x-4">
                @include('components.language-selector')
            </div>
        </header>

        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-lg bg-emerald-950/60 border border-emerald-800/80 text-emerald-300 text-sm flex items-center space-x-3">
                    <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
@endsection
