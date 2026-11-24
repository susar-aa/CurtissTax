@extends('layouts.public')

@section('title', __('app.nav_pricing') . ' – ' . __('app.brand'))
@section('meta_description', __('app.pricing_subtitle'))

@section('content')
<div class="relative overflow-hidden pt-12 pb-24 lg:pt-20" x-data="{ annual: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-4">
            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-neutral-900 border border-neutral-800 text-neutral-300">
                <i data-lucide="sparkles" class="w-3.5 h-3.5 text-white"></i>
                <span>{{ __('app.currency') }}</span>
            </div>
            <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-white">
                {{ __('app.pricing_title') }}
            </h1>
            <p class="text-base text-neutral-400">
                {{ __('app.pricing_subtitle') }}
            </p>

            <!-- Monthly / Annual Toggle -->
            <div class="flex items-center justify-center gap-3 pt-4">
                <span :class="!annual ? 'text-white font-semibold' : 'text-neutral-500'"
                      class="text-xs cursor-pointer select-none"
                      @click="annual = false">
                    {{ __('app.pricing_monthly') }}
                </span>
                <button type="button"
                        @click="annual = !annual"
                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-neutral-800 transition-colors duration-200 ease-in-out focus:outline-none"
                        :class="annual ? 'bg-white' : 'bg-neutral-800'"
                        role="switch">
                    <span aria-hidden="true"
                          class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-neutral-950 shadow ring-0 transition duration-200 ease-in-out"
                          :class="annual ? 'translate-x-5 bg-neutral-950' : 'translate-x-0 bg-neutral-400'"></span>
                </button>
                <span :class="annual ? 'text-white font-semibold' : 'text-neutral-500'"
                      class="text-xs cursor-pointer select-none flex items-center gap-1.5"
                      @click="annual = true">
                    <span>{{ __('app.pricing_annually') }}</span>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">{{ __('app.pricing_save_tag') }}</span>
                </span>
            </div>
        </div>

        <!-- Plans Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($plans as $plan)
            <div class="p-8 rounded-2xl bg-neutral-900/60 border {{ $plan->slug === 'professional' ? 'border-neutral-300 ring-1 ring-neutral-400/50 shadow-2xl' : 'border-neutral-800' }} hover:border-neutral-700 transition flex flex-col justify-between space-y-6">
                <div class="space-y-5">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-white">{{ $plan->name }}</h2>
                        @if($plan->slug === 'professional')
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-white text-neutral-950">Most Popular</span>
                        @endif
                    </div>
                    <p class="text-xs text-neutral-400 leading-relaxed">{{ $plan->description }}</p>

                    <div class="pt-2">
                        <div class="flex items-baseline gap-1">
                            <span class="text-xs text-neutral-400 font-mono">LKR</span>
                            <span class="text-4xl font-extrabold text-white font-mono" x-show="!annual">
                                {{ number_format($plan->price_lkr_monthly, 0) }}
                            </span>
                            <span class="text-4xl font-extrabold text-white font-mono" x-show="annual" style="display: none;">
                                {{ number_format($plan->price_lkr_annually / 12, 0) }}
                            </span>
                            <span class="text-xs text-neutral-500"> {{ __('app.per_month') }}</span>
                        </div>
                        <div class="text-[11px] text-neutral-500 mt-1" x-show="annual" style="display: none;">
                            Billed LKR {{ number_format($plan->price_lkr_annually, 0) }} {{ __('app.per_year') }}
                        </div>
                    </div>

                    <div class="border-t border-neutral-800 pt-5 space-y-3 text-xs text-neutral-300">
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                            <span>{{ $plan->max_users }} {{ $plan->max_users == 1 ? 'Authorized User' : 'Authorized Users' }}</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                            <span>{{ $plan->max_invoices_per_month }} Monthly Tax Invoices</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                            <span>{{ $plan->max_branches }} {{ $plan->max_branches == 1 ? 'Branch Location' : 'Branch Locations' }}</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                            <span>VAT & Non-VAT Invoice Modes</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                            <span>Sinhala, Tamil & English Support</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                            <span>Audit Trails & Tenant Encryption</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('register') }}"
                   class="w-full py-3 px-4 rounded-lg text-center text-xs font-semibold transition {{ $plan->slug === 'professional' ? 'bg-white text-neutral-950 hover:bg-neutral-200 shadow-md' : 'bg-neutral-800 text-white hover:bg-neutral-700' }}">
                    {{ __('app.nav_register') }}
                </a>
            </div>
            @endforeach
        </div>

        <!-- 14-Day Free Trial Notice Banner -->
        <div class="rounded-2xl bg-neutral-900 border border-neutral-800 p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-1 text-center md:text-left">
                <h3 class="text-lg font-bold text-white">{{ __('app.trial_banner_title') }}</h3>
                <p class="text-xs text-neutral-400">
                    {{ __('app.hero_trial_note') }}
                </p>
            </div>
            <a href="{{ route('register') }}" class="px-6 py-3 rounded-lg bg-white text-neutral-950 text-xs font-semibold hover:bg-neutral-200 transition flex-shrink-0">
                {{ __('app.nav_register') }}
            </a>
        </div>

        <!-- Plan FAQ -->
        <div class="space-y-8 max-w-4xl mx-auto pt-8" x-data="{ active: null }">
            <div class="text-center space-y-2">
                <h2 class="text-2xl font-bold text-white">{{ __('app.faq_title') }}</h2>
                <p class="text-xs text-neutral-400">{{ __('app.faq_subtitle') }}</p>
            </div>

            <div class="space-y-4">
                @php
                    $pricingFaqs = [
                        ['q' => __('app.faq_q1'), 'a' => __('app.faq_a1')],
                        ['q' => __('app.faq_q2'), 'a' => __('app.faq_a2')],
                        ['q' => __('app.faq_q5'), 'a' => __('app.faq_a5')],
                    ];
                @endphp

                @foreach($pricingFaqs as $idx => $faq)
                <div class="rounded-xl border border-neutral-800 bg-neutral-900/60 overflow-hidden">
                    <button type="button"
                            @click="active = (active === {{ $idx }} ? null : {{ $idx }})"
                            class="w-full px-6 py-4 text-left flex items-center justify-between text-white font-medium text-xs hover:bg-neutral-800/40 transition">
                        <span>{{ $faq['q'] }}</span>
                        <i data-lucide="chevron-down"
                           class="w-4 h-4 text-neutral-400 transition-transform duration-200"
                           :class="{ 'rotate-180': active === {{ $idx }} }"></i>
                    </button>
                    <div x-show="active === {{ $idx }}"
                         x-collapse
                         class="px-6 pb-4 text-xs text-neutral-400 leading-relaxed border-t border-neutral-800/50 pt-3"
                         style="display: none;">
                        {{ $faq['a'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
