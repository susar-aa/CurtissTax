@extends('layouts.app')

@section('title', __('app.nav_subscription') . ' – ' . __('app.brand'))

@section('content')
<div class="space-y-8">
    <div class="border-b border-neutral-800 pb-4">
        <h1 class="text-2xl font-bold tracking-tight text-white">{{ __('app.nav_subscription') }}</h1>
        <p class="text-xs text-neutral-400 mt-1">Manage your 14-day free trial, active plan, user capacities, and billing history.</p>
    </div>

    <!-- Active Status Card -->
    <div class="p-6 rounded-xl bg-neutral-900 border border-neutral-800 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div class="space-y-2">
            <div class="flex items-center space-x-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-neutral-400">Current Status:</span>
                @if($business->isTrialActive())
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold bg-amber-950 text-amber-300 border border-amber-800/80">
                        14-Day Free Trial (Active)
                    </span>
                @elseif($business->hasActiveSubscription())
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold bg-emerald-950 text-emerald-300 border border-emerald-800/80">
                        Subscribed (Active)
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold bg-red-950 text-red-300 border border-red-800/80">
                        Expired (Read-Only)
                    </span>
                @endif
            </div>

            <div class="text-xs text-neutral-300">
                @if($business->isTrialActive())
                    Trial started on <strong class="text-white">{{ $business->trial_starts_at ? $business->trial_starts_at->format('M d, Y') : '—' }}</strong>.
                    Expires on <strong class="text-white">{{ $business->trial_ends_at ? $business->trial_ends_at->format('M d, Y') : '—' }}</strong>
                    (<span class="text-amber-400 font-bold">{{ $business->daysRemainingInTrial() }} days remaining</span>).
                @elseif($business->isTrialExpired() && !$business->hasActiveSubscription())
                    Trial expired on <strong class="text-white">{{ $business->trial_ends_at ? $business->trial_ends_at->format('M d, Y') : '—' }}</strong>.
                    Account is in <span class="text-red-400 font-bold">read-only mode</span>. Upgrade below to restore full invoice creation.
                @endif
            </div>
        </div>

        <div class="text-xs text-neutral-400 font-mono bg-neutral-950 px-4 py-3 rounded-lg border border-neutral-800">
            <div>Business UUID: <span class="text-neutral-300">{{ $business->uuid }}</span></div>
            <div>Max Users: <span class="text-neutral-300">{{ $currentPlan ? $currentPlan->max_users : 2 }}</span></div>
            <div>Branches: <span class="text-neutral-300">{{ $currentPlan ? $currentPlan->max_branches : 1 }}</span></div>
        </div>
    </div>

    <!-- Available Plans -->
    <div class="space-y-4">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-white">Choose a Production Subscription</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($availablePlans as $plan)
                <div class="rounded-xl bg-neutral-900 border {{ $plan->slug === 'professional' ? 'border-white' : 'border-neutral-800' }} p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <h4 class="text-base font-bold text-white">{{ $plan->name }}</h4>
                            @if($plan->slug === 'professional')
                                <span class="text-[10px] uppercase font-bold bg-white text-neutral-950 px-2 py-0.5 rounded">Recommended</span>
                            @endif
                        </div>
                        <p class="text-xs text-neutral-400 mt-1">{{ $plan->description }}</p>

                        <div class="mt-4 flex items-baseline">
                            <span class="text-2xl font-extrabold text-white">LKR {{ number_format($plan->price_lkr_monthly) }}</span>
                            <span class="ml-1.5 text-xs text-neutral-400">/mo</span>
                        </div>

                        <ul class="mt-4 space-y-2 text-xs text-neutral-300">
                            <li class="flex items-center space-x-2">
                                <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-400"></i>
                                <span>{{ $plan->max_users }} Authorized Users</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-400"></i>
                                <span>{{ $plan->max_invoices_per_month }} Invoices / month</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-400"></i>
                                <span>{{ $plan->max_branches }} Branch Profile(s)</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-400"></i>
                                <span>Trilingual Print (EN, SI, TA)</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-6 pt-4 border-t border-neutral-800">
                        <button type="button"
                                class="w-full py-2 text-center text-xs font-semibold rounded-lg transition {{ $plan->slug === 'professional' ? 'bg-white text-neutral-950 hover:bg-neutral-200' : 'bg-neutral-800 text-white hover:bg-neutral-700' }}">
                            Select {{ $plan->name }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Subscription History -->
    @if($history->isNotEmpty())
        <div class="bg-neutral-900 border border-neutral-800 rounded-xl overflow-hidden">
            <div class="px-5 py-3 border-b border-neutral-800">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-white">Subscription History</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-neutral-950/60 text-neutral-400 uppercase tracking-wider text-[11px] border-b border-neutral-800">
                        <tr>
                            <th class="px-5 py-2.5">Plan</th>
                            <th class="px-5 py-2.5">Status</th>
                            <th class="px-5 py-2.5">Cycle</th>
                            <th class="px-5 py-2.5">Starts At</th>
                            <th class="px-5 py-2.5">Ends At</th>
                            <th class="px-5 py-2.5">Amount (LKR)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-800/60 text-neutral-300">
                        @foreach($history as $item)
                            <tr>
                                <td class="px-5 py-3 font-medium text-white">{{ $item->plan_name }}</td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold uppercase bg-neutral-800 text-neutral-300">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 uppercase text-neutral-400 font-mono text-[11px]">{{ $item->billing_cycle }}</td>
                                <td class="px-5 py-3 font-mono text-[11px]">{{ \Carbon\Carbon::parse($item->starts_at)->format('Y-m-d') }}</td>
                                <td class="px-5 py-3 font-mono text-[11px]">{{ $item->ends_at ? \Carbon\Carbon::parse($item->ends_at)->format('Y-m-d') : '—' }}</td>
                                <td class="px-5 py-3 font-mono font-medium text-white">LKR {{ number_format($item->amount_paid, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
