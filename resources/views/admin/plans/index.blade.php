@extends('layouts.admin')

@section('title', __('app.admin_plans') . ' – ' . __('app.brand'))

@section('content')
<div class="space-y-6">
    <div class="border-b border-neutral-800 pb-4">
        <h1 class="text-2xl font-bold tracking-tight text-white">{{ __('app.admin_plans') }}</h1>
        <p class="text-xs text-neutral-400 mt-1">Configure SaaS pricing tiers, user allocations, and feature sets in LKR.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($plans as $plan)
            <div class="rounded-xl bg-neutral-900 border border-neutral-800 p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white">{{ $plan->name }}</h3>
                    <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-neutral-800 text-neutral-300 uppercase">
                        {{ $plan->is_active ? 'Active' : 'Disabled' }}
                    </span>
                </div>
                <div class="text-xs text-neutral-400">{{ $plan->description }}</div>
                <div class="pt-2 border-t border-neutral-800 space-y-1">
                    <div class="text-xl font-bold text-white">LKR {{ number_format($plan->price_lkr_monthly) }} <span class="text-xs font-normal text-neutral-400">/mo</span></div>
                    <div class="text-xs text-neutral-500">LKR {{ number_format($plan->price_lkr_annually) }} /yr</div>
                </div>
                <div class="space-y-1.5 text-xs text-neutral-300 pt-2 border-t border-neutral-800">
                    <div>• Max Users: <strong>{{ $plan->max_users }}</strong></div>
                    <div>• Monthly Invoices: <strong>{{ $plan->max_invoices_per_month }}</strong></div>
                    <div>• Max Branches: <strong>{{ $plan->max_branches }}</strong></div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
