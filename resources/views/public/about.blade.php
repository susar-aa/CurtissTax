@extends('layouts.public')

@section('title', __('app.nav_about') . ' – ' . __('app.brand'))
@section('meta_description', __('app.about_mission_desc'))

@section('content')
<div class="relative overflow-hidden pt-12 pb-24 lg:pt-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-4">
            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-neutral-900 border border-neutral-800 text-neutral-300">
                <i data-lucide="building" class="w-3.5 h-3.5 text-white"></i>
                <span>CurtissTax</span>
            </div>
            <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-white">
                {{ __('app.about_title') }}
            </h1>
            <p class="text-base text-neutral-400">
                {{ __('app.about_subtitle') }}
            </p>
        </div>

        <!-- Story Content -->
        <div class="rounded-3xl bg-neutral-900/60 border border-neutral-800 p-8 sm:p-12 space-y-6 text-neutral-300 leading-relaxed text-sm">
            <h2 class="text-xl font-bold text-white">{{ __('app.about_mission_title') }}</h2>
            <p class="text-neutral-400">
                {{ __('app.about_mission_desc') }}
            </p>
            <p class="text-neutral-400">
                {{ __('app.about_sri_lanka_desc') }}
            </p>
        </div>

        <!-- 3 Core Pillars -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-6 rounded-2xl bg-neutral-900/60 border border-neutral-800 space-y-3">
                <div class="w-10 h-10 rounded-lg bg-neutral-800 flex items-center justify-center text-white">
                    <i data-lucide="scale" class="w-5 h-5"></i>
                </div>
                <h3 class="text-base font-bold text-white">{{ __('app.feat_f1_title') }}</h3>
                <p class="text-xs text-neutral-400 leading-relaxed">{{ __('app.feat_f1_desc') }}</p>
            </div>

            <div class="p-6 rounded-2xl bg-neutral-900/60 border border-neutral-800 space-y-3">
                <div class="w-10 h-10 rounded-lg bg-neutral-800 flex items-center justify-center text-white">
                    <i data-lucide="languages" class="w-5 h-5"></i>
                </div>
                <h3 class="text-base font-bold text-white">{{ __('app.feat_f3_title') }}</h3>
                <p class="text-xs text-neutral-400 leading-relaxed">{{ __('app.feat_f3_desc') }}</p>
            </div>

            <div class="p-6 rounded-2xl bg-neutral-900/60 border border-neutral-800 space-y-3">
                <div class="w-10 h-10 rounded-lg bg-neutral-800 flex items-center justify-center text-white">
                    <i data-lucide="shield-check" class="w-5 h-5"></i>
                </div>
                <h3 class="text-base font-bold text-white">{{ __('app.feat_f4_title') }}</h3>
                <p class="text-xs text-neutral-400 leading-relaxed">{{ __('app.feat_f4_desc') }}</p>
            </div>
        </div>

        <!-- Compliance & Hosting Commitment -->
        <div class="rounded-2xl border border-neutral-800 bg-neutral-900/40 p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="space-y-1 text-center sm:text-left">
                <h3 class="text-base font-bold text-white">Sri Lankan Customer Support</h3>
                <p class="text-xs text-neutral-400">Our support engineers assist with business onboarding and IRD configuration.</p>
            </div>
            <a href="{{ route('contact') }}" class="px-6 py-2.5 rounded-lg bg-white text-neutral-950 text-xs font-semibold hover:bg-neutral-200 transition flex-shrink-0">
                {{ __('app.nav_contact') }}
            </a>
        </div>

    </div>
</div>
@endsection
