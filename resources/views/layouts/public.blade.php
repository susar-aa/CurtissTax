@extends('layouts.base')

@section('body')
<div class="flex flex-col min-h-screen" x-data="{ mobileMenuOpen: false }">
    <!-- Public Navigation Bar -->
    <header class="border-b border-neutral-800/80 bg-neutral-950/90 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-8">
                <a href="{{ route('home') }}" class="flex items-center space-x-2.5 group">
                    <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-neutral-950 font-extrabold text-base shadow-sm group-hover:scale-105 transition-transform">
                        C
                    </div>
                    <span class="font-bold text-lg tracking-tight text-white">Curtiss<span class="text-neutral-400">Tax</span></span>
                </a>
                <nav class="hidden md:flex items-center space-x-7 text-sm font-medium text-neutral-400">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors {{ request()->routeIs('home') ? 'text-white font-semibold' : '' }}">{{ __('app.nav_home') }}</a>
                    <a href="{{ route('features') }}" class="hover:text-white transition-colors {{ request()->routeIs('features') ? 'text-white font-semibold' : '' }}">{{ __('app.nav_features') }}</a>
                    <a href="{{ route('pricing') }}" class="hover:text-white transition-colors {{ request()->routeIs('pricing') ? 'text-white font-semibold' : '' }}">{{ __('app.nav_pricing') }}</a>
                    <a href="{{ route('about') }}" class="hover:text-white transition-colors {{ request()->routeIs('about') ? 'text-white font-semibold' : '' }}">{{ __('app.nav_about') }}</a>
                    <a href="{{ route('contact') }}" class="hover:text-white transition-colors {{ request()->routeIs('contact') ? 'text-white font-semibold' : '' }}">{{ __('app.nav_contact') }}</a>
                </nav>
            </div>

            <div class="flex items-center space-x-3 sm:space-x-4">
                <!-- Language Selector -->
                @include('components.language-selector')

                @auth
                    <a href="{{ route('app.dashboard') }}" class="text-xs sm:text-sm font-medium bg-neutral-900 hover:bg-neutral-800 text-white px-3.5 py-1.5 rounded-lg border border-neutral-700 transition flex items-center space-x-1.5">
                        <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i>
                        <span>{{ __('app.nav_dashboard') }}</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-block text-xs sm:text-sm font-medium text-neutral-300 hover:text-white transition">
                        {{ __('app.nav_login') }}
                    </a>
                    <a href="{{ route('register') }}" class="text-xs sm:text-sm font-semibold bg-white text-neutral-950 hover:bg-neutral-200 px-3.5 sm:px-4 py-1.5 rounded-lg transition shadow-sm">
                        {{ __('app.nav_register') }}
                    </a>
                @endauth

                <!-- Mobile menu button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        type="button"
                        class="md:hidden text-neutral-400 hover:text-white p-1 rounded-md focus:outline-none"
                        aria-label="Toggle Navigation">
                    <i :data-lucide="mobileMenuOpen ? 'x' : 'menu'" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden border-b border-neutral-800 bg-neutral-950 px-4 pt-2 pb-4 space-y-2 text-sm"
             style="display: none;">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-neutral-300 hover:text-white hover:bg-neutral-900 {{ request()->routeIs('home') ? 'bg-neutral-900 text-white font-semibold' : '' }}">{{ __('app.nav_home') }}</a>
            <a href="{{ route('features') }}" class="block px-3 py-2 rounded-lg text-neutral-300 hover:text-white hover:bg-neutral-900 {{ request()->routeIs('features') ? 'bg-neutral-900 text-white font-semibold' : '' }}">{{ __('app.nav_features') }}</a>
            <a href="{{ route('pricing') }}" class="block px-3 py-2 rounded-lg text-neutral-300 hover:text-white hover:bg-neutral-900 {{ request()->routeIs('pricing') ? 'bg-neutral-900 text-white font-semibold' : '' }}">{{ __('app.nav_pricing') }}</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg text-neutral-300 hover:text-white hover:bg-neutral-900 {{ request()->routeIs('about') ? 'bg-neutral-900 text-white font-semibold' : '' }}">{{ __('app.nav_about') }}</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-lg text-neutral-300 hover:text-white hover:bg-neutral-900 {{ request()->routeIs('contact') ? 'bg-neutral-900 text-white font-semibold' : '' }}">{{ __('app.nav_contact') }}</a>
            @guest
                <div class="pt-2 border-t border-neutral-800 flex items-center justify-between px-3">
                    <a href="{{ route('login') }}" class="text-neutral-300 hover:text-white">{{ __('app.nav_login') }}</a>
                    <a href="{{ route('register') }}" class="text-xs font-semibold bg-white text-neutral-950 px-3 py-1.5 rounded-lg">{{ __('app.nav_register') }}</a>
                </div>
            @endguest
        </div>
    </header>

    <!-- Main Public Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-neutral-800 bg-neutral-950/95 text-neutral-400 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                <!-- Col 1: Brand & Overview -->
                <div class="col-span-2 md:col-span-1 space-y-3">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-7 h-7 rounded-lg bg-white flex items-center justify-center text-neutral-950 font-bold text-sm">
                            C
                        </div>
                        <span class="font-bold text-base text-white tracking-tight">Curtiss<span class="text-neutral-400">Tax</span></span>
                    </div>
                    <p class="text-neutral-500 text-xs leading-relaxed">
                        {{ __('app.tagline') }}. Designed for Sri Lankan business tax compliance, IRD specifications, and modern bookkeeping.
                    </p>
                    <div class="pt-1 flex items-center space-x-2 text-[11px] text-neutral-500 font-mono">
                        <span>LKR Currency</span>
                        <span>•</span>
                        <span>LK Domain</span>
                    </div>
                </div>

                <!-- Col 2: Product -->
                <div class="space-y-3">
                    <h3 class="text-xs font-semibold text-white uppercase tracking-wider">Product</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('features') }}" class="hover:text-white transition">{{ __('app.nav_features') }}</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-white transition">{{ __('app.nav_pricing') }}</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition">14-Day Free Trial</a></li>
                        <li><a href="{{ route('home') }}#sample-invoice" class="hover:text-white transition">Sample Tax Invoice</a></li>
                    </ul>
                </div>

                <!-- Col 3: Compliance & Guides -->
                <div class="space-y-3">
                    <h3 class="text-xs font-semibold text-white uppercase tracking-wider">Compliance</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('features') }}#vat-vs-non-vat" class="hover:text-white transition">VAT vs Non-VAT Entities</a></li>
                        <li><a href="{{ route('about') }}#ird-compliance" class="hover:text-white transition">IRD Guidelines</a></li>
                        <li><a href="{{ route('home') }}#how-it-works" class="hover:text-white transition">How It Works</a></li>
                        <li><a href="{{ route('home') }}#faq" class="hover:text-white transition">Common Questions</a></li>
                    </ul>
                </div>

                <!-- Col 4: Company & Legal -->
                <div class="space-y-3">
                    <h3 class="text-xs font-semibold text-white uppercase tracking-wider">Company & Legal</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('about') }}" class="hover:text-white transition">{{ __('app.nav_about') }}</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition">{{ __('app.nav_contact') }}</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-white transition">Terms of Service</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-white transition">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-8 border-t border-neutral-900 flex flex-col sm:flex-row items-center justify-between text-neutral-500 gap-4">
                <div>
                    &copy; {{ date('Y') }} CurtissTax. {{ __('app.all_rights_reserved') }}
                </div>
                <div class="flex items-center space-x-6 text-[11px]">
                    <span class="flex items-center space-x-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        <span class="text-neutral-400">Trilingual: English • සිංහල • தமிழ்</span>
                    </span>
                    <span>Colombo, Sri Lanka</span>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection
