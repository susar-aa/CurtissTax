@extends('layouts.app')

@section('title', __('app.nav_dashboard') . ' – ' . __('app.brand'))

@section('content')
<div class="space-y-6">
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">{{ $business->name }}</h1>
            <p class="text-xs text-neutral-400 mt-1">
                {{ __('app.legal_name') }}: <span class="text-neutral-200">{{ $business->legal_name ?: $business->name }}</span>
                @if($business->registration_number)
                    • BRN: <span class="text-neutral-200">{{ $business->registration_number }}</span>
                @endif
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('app.settings.index') }}"
               class="px-3.5 py-1.5 rounded-lg bg-neutral-900 border border-neutral-800 text-neutral-300 hover:text-white hover:border-neutral-700 text-xs font-medium transition flex items-center space-x-2">
                <i data-lucide="settings" class="w-3.5 h-3.5"></i>
                <span>{{ __('app.nav_settings') }}</span>
            </a>
            <a href="{{ route('app.team.index') }}"
               class="px-3.5 py-1.5 rounded-lg bg-white text-neutral-950 hover:bg-neutral-200 text-xs font-semibold transition flex items-center space-x-2 shadow-sm">
                <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                <span>{{ __('app.invite_member') }}</span>
            </a>
        </div>
    </div>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- VAT Status Card -->
        <div class="p-5 rounded-xl bg-neutral-900/80 border border-neutral-800 space-y-2">
            <div class="flex items-center justify-between text-neutral-400">
                <span class="text-xs font-medium uppercase tracking-wider">Tax Registration</span>
                <i data-lucide="file-check-2" class="w-4 h-4 text-neutral-400"></i>
            </div>
            <div class="text-xl font-bold text-white">
                {{ $business->is_vat_registered ? 'VAT Registered' : 'Non-VAT Entity' }}
            </div>
            <div class="text-[11px] text-neutral-400">
                TIN: <strong class="text-neutral-200">{{ $business->tin ?: 'Not entered' }}</strong>
            </div>
        </div>

        <!-- Trial / Subscription Status Card -->
        <div class="p-5 rounded-xl bg-neutral-900/80 border border-neutral-800 space-y-2">
            <div class="flex items-center justify-between text-neutral-400">
                <span class="text-xs font-medium uppercase tracking-wider">Subscription</span>
                <i data-lucide="credit-card" class="w-4 h-4 text-neutral-400"></i>
            </div>
            <div class="text-xl font-bold text-white">
                @if($business->isTrialActive())
                    <span class="text-amber-400">Free Trial</span>
                @elseif($business->hasActiveSubscription())
                    <span class="text-emerald-400">Active</span>
                @else
                    <span class="text-red-400">Expired</span>
                @endif
            </div>
            <div class="text-[11px] text-neutral-400">
                @if($business->isTrialActive())
                    {{ $business->daysRemainingInTrial() }} days remaining
                @else
                    Plan: <strong class="text-neutral-200">{{ $business->currentPlan ? $business->currentPlan->name : 'Trial' }}</strong>
                @endif
            </div>
        </div>

        <!-- Team Members Card -->
        <div class="p-5 rounded-xl bg-neutral-900/80 border border-neutral-800 space-y-2">
            <div class="flex items-center justify-between text-neutral-400">
                <span class="text-xs font-medium uppercase tracking-wider">Active Team</span>
                <i data-lucide="users" class="w-4 h-4 text-neutral-400"></i>
            </div>
            <div class="text-xl font-bold text-white">
                {{ $activeTeamCount }} <span class="text-xs font-normal text-neutral-400">Member(s)</span>
            </div>
            <div class="text-[11px] text-neutral-400">
                Limit: <strong class="text-neutral-200">{{ $business->currentPlan ? $business->currentPlan->max_users : 2 }}</strong> accounts
            </div>
        </div>

        <!-- Next Sequence Counter Card -->
        <div class="p-5 rounded-xl bg-neutral-900/80 border border-neutral-800 space-y-2">
            <div class="flex items-center justify-between text-neutral-400">
                <span class="text-xs font-medium uppercase tracking-wider">Invoice Sequence</span>
                <i data-lucide="hash" class="w-4 h-4 text-neutral-400"></i>
            </div>
            <div class="text-xl font-bold text-white">
                {{ $business->settings->invoice_prefix ?? 'INV-' }}{{ $business->settings->invoice_next_number ?? 1001 }}
            </div>
            <div class="text-[11px] text-neutral-400">
                Language: <strong class="text-neutral-200 uppercase">{{ $business->settings->invoice_locale ?? 'EN' }}</strong>
            </div>
        </div>
    </div>

    <!-- Recent Audit Activity -->
    <div class="rounded-xl bg-neutral-900/80 border border-neutral-800 p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
            <h3 class="text-sm font-semibold text-white flex items-center space-x-2">
                <i data-lucide="history" class="w-4 h-4 text-neutral-400"></i>
                <span>Recent Audit Activity</span>
            </h3>
            <a href="{{ route('app.audit-logs.index') }}" class="text-xs text-neutral-400 hover:text-white transition">
                View all logs &rarr;
            </a>
        </div>

        @if($recentAudits->isEmpty())
            <div class="text-center py-6 text-xs text-neutral-500">
                No recent audit activities recorded.
            </div>
        @else
            <div class="divide-y divide-neutral-800/60">
                @foreach($recentAudits as $log)
                    <div class="py-2.5 flex items-center justify-between text-xs">
                        <div class="flex items-center space-x-3">
                            <span class="px-2 py-0.5 rounded text-[10px] font-mono font-medium bg-neutral-800 text-neutral-300">
                                {{ $log->event }}
                            </span>
                            <span class="text-neutral-300">{{ class_basename($log->auditable_type) }}</span>
                            <span class="text-neutral-500">•</span>
                            <span class="text-neutral-400">{{ $log->user_name }}</span>
                        </div>
                        <span class="text-neutral-500 font-mono text-[11px]">
                            {{ $log->created_at->diffForHumans() }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
