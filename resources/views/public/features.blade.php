@extends('layouts.public')

@section('title', __('app.nav_features') . ' – ' . __('app.brand'))
@section('meta_description', __('app.feat_page_subtitle'))

@section('content')
<div class="relative overflow-hidden pt-12 pb-24 lg:pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">

        <!-- Hero -->
        <div class="text-center max-w-3xl mx-auto space-y-4">
            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-neutral-900 border border-neutral-800 text-neutral-300">
                <i data-lucide="layers" class="w-3.5 h-3.5 text-white"></i>
                <span>{{ __('app.nav_features') }}</span>
            </div>
            <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-white">
                {{ __('app.feat_page_title') }}
            </h1>
            <p class="text-base text-neutral-400">
                {{ __('app.feat_page_subtitle') }}
            </p>
        </div>

        <!-- 6 Core Feature Pillars -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- 1. IRD Compliance -->
            <div class="p-8 rounded-2xl bg-neutral-900/60 border border-neutral-800 hover:border-neutral-700 transition space-y-4">
                <div class="w-12 h-12 rounded-xl bg-neutral-800 flex items-center justify-center text-white">
                    <i data-lucide="file-text" class="w-6 h-6"></i>
                </div>
                <h2 class="text-lg font-bold text-white">{{ __('app.feat_f1_title') }}</h2>
                <p class="text-xs text-neutral-400 leading-relaxed">{{ __('app.feat_f1_desc') }}</p>
            </div>

            <!-- 2. Dual VAT Modes -->
            <div class="p-8 rounded-2xl bg-neutral-900/60 border border-neutral-800 hover:border-neutral-700 transition space-y-4">
                <div class="w-12 h-12 rounded-xl bg-neutral-800 flex items-center justify-center text-white">
                    <i data-lucide="scale" class="w-6 h-6"></i>
                </div>
                <h2 class="text-lg font-bold text-white">{{ __('app.feat_f2_title') }}</h2>
                <p class="text-xs text-neutral-400 leading-relaxed">{{ __('app.feat_f2_desc') }}</p>
            </div>

            <!-- 3. Trilingual Localization -->
            <div class="p-8 rounded-2xl bg-neutral-900/60 border border-neutral-800 hover:border-neutral-700 transition space-y-4">
                <div class="w-12 h-12 rounded-xl bg-neutral-800 flex items-center justify-center text-white">
                    <i data-lucide="languages" class="w-6 h-6"></i>
                </div>
                <h2 class="text-lg font-bold text-white">{{ __('app.feat_f3_title') }}</h2>
                <p class="text-xs text-neutral-400 leading-relaxed">{{ __('app.feat_f3_desc') }}</p>
            </div>

            <!-- 4. Multi-Tenant Isolation -->
            <div class="p-8 rounded-2xl bg-neutral-900/60 border border-neutral-800 hover:border-neutral-700 transition space-y-4">
                <div class="w-12 h-12 rounded-xl bg-neutral-800 flex items-center justify-center text-white">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <h2 class="text-lg font-bold text-white">{{ __('app.feat_f4_title') }}</h2>
                <p class="text-xs text-neutral-400 leading-relaxed">{{ __('app.feat_f4_desc') }}</p>
            </div>

            <!-- 5. Audit Trails -->
            <div class="p-8 rounded-2xl bg-neutral-900/60 border border-neutral-800 hover:border-neutral-700 transition space-y-4">
                <div class="w-12 h-12 rounded-xl bg-neutral-800 flex items-center justify-center text-white">
                    <i data-lucide="history" class="w-6 h-6"></i>
                </div>
                <h2 class="text-lg font-bold text-white">{{ __('app.feat_f6_title') }}</h2>
                <p class="text-xs text-neutral-400 leading-relaxed">{{ __('app.feat_f6_desc') }}</p>
            </div>

            <!-- 6. Role-Based Access -->
            <div class="p-8 rounded-2xl bg-neutral-900/60 border border-neutral-800 hover:border-neutral-700 transition space-y-4">
                <div class="w-12 h-12 rounded-xl bg-neutral-800 flex items-center justify-center text-white">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <h2 class="text-lg font-bold text-white">{{ __('app.feat_f5_title') }}</h2>
                <p class="text-xs text-neutral-400 leading-relaxed">{{ __('app.feat_f5_desc') }}</p>
            </div>
        </div>

        <!-- Comparative Deep Dive -->
        <div class="p-8 sm:p-12 rounded-3xl bg-neutral-900/80 border border-neutral-800 space-y-8">
            <div class="max-w-2xl space-y-2">
                <h2 class="text-2xl font-bold text-white">{{ __('app.about_sri_lanka_title') }}</h2>
                <p class="text-xs text-neutral-400 leading-relaxed">
                    {{ __('app.about_sri_lanka_desc') }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 text-xs text-neutral-300">
                <div class="p-5 rounded-xl bg-neutral-950/60 border border-neutral-800/80 space-y-2">
                    <div class="font-bold text-white flex items-center gap-2">
                        <i data-lucide="check-square" class="w-4 h-4 text-emerald-400"></i>
                        <span>{{ __('app.feat_f2_title') }}</span>
                    </div>
                    <p class="text-neutral-400">{{ __('app.feat_f2_desc') }}</p>
                </div>

                <div class="p-5 rounded-xl bg-neutral-950/60 border border-neutral-800/80 space-y-2">
                    <div class="font-bold text-white flex items-center gap-2">
                        <i data-lucide="check-square" class="w-4 h-4 text-emerald-400"></i>
                        <span>{{ __('app.feat_f1_title') }}</span>
                    </div>
                    <p class="text-neutral-400">{{ __('app.feat_f1_desc') }}</p>
                </div>

                <div class="p-5 rounded-xl bg-neutral-950/60 border border-neutral-800/80 space-y-2">
                    <div class="font-bold text-white flex items-center gap-2">
                        <i data-lucide="check-square" class="w-4 h-4 text-emerald-400"></i>
                        <span>{{ __('app.trial_banner_title') }}</span>
                    </div>
                    <p class="text-neutral-400">{{ __('app.hero_trial_note') }}</p>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center space-y-4 pt-4">
            <h2 class="text-2xl font-bold text-white">{{ __('app.hero_cta_primary') }}</h2>
            <p class="text-xs text-neutral-400 max-w-lg mx-auto">{{ __('app.hero_trial_note') }}</p>
            <div class="pt-2">
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-2 px-8 py-3.5 rounded-lg bg-white text-neutral-950 font-semibold hover:bg-neutral-200 transition shadow-lg text-xs">
                    <span>{{ __('app.nav_register') }}</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
