@extends('layouts.admin')

@section('title', __('app.admin_dashboard') . ' – ' . __('app.brand'))

@section('content')
<div class="space-y-6">
    <div class="border-b border-neutral-800 pb-4">
        <h1 class="text-2xl font-bold tracking-tight text-white">{{ __('app.admin_dashboard') }}</h1>
        <p class="text-xs text-neutral-400 mt-1">Cross-tenant overview of all Sri Lankan businesses, subscriptions, and platform metrics.</p>
    </div>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-5 rounded-xl bg-neutral-900 border border-neutral-800 space-y-1">
            <span class="text-xs font-medium uppercase tracking-wider text-neutral-400">Total Registered</span>
            <div class="text-2xl font-bold text-white">{{ $totalBusinesses }}</div>
            <div class="text-[11px] text-neutral-500">Businesses on platform</div>
        </div>

        <div class="p-5 rounded-xl bg-neutral-900 border border-neutral-800 space-y-1">
            <span class="text-xs font-medium uppercase tracking-wider text-neutral-400">Active Trials</span>
            <div class="text-2xl font-bold text-amber-400">{{ $activeTrials }}</div>
            <div class="text-[11px] text-neutral-500">In 14-day evaluation</div>
        </div>

        <div class="p-5 rounded-xl bg-neutral-900 border border-neutral-800 space-y-1">
            <span class="text-xs font-medium uppercase tracking-wider text-neutral-400">Paid Subscriptions</span>
            <div class="text-2xl font-bold text-emerald-400">{{ $activeSubscriptions }}</div>
            <div class="text-[11px] text-neutral-500">Active paid tiers</div>
        </div>

        <div class="p-5 rounded-xl bg-neutral-900 border border-neutral-800 space-y-1">
            <span class="text-xs font-medium uppercase tracking-wider text-neutral-400">Expired Accounts</span>
            <div class="text-2xl font-bold text-red-400">{{ $expiredAccounts }}</div>
            <div class="text-[11px] text-neutral-500">Read-only state</div>
        </div>
    </div>

    <!-- Recent Businesses -->
    <div class="bg-neutral-900 border border-neutral-800 rounded-xl overflow-hidden">
        <div class="px-5 py-4 border-b border-neutral-800 flex items-center justify-between">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-white">Recently Registered Businesses</h3>
            <a href="{{ route('admin.businesses.index') }}" class="text-xs text-neutral-400 hover:text-white">View all &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-neutral-950/60 text-neutral-400 uppercase tracking-wider text-[11px] border-b border-neutral-800">
                    <tr>
                        <th class="px-5 py-3">Business</th>
                        <th class="px-5 py-3">Owner</th>
                        <th class="px-5 py-3">Tax Numbers</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Subscription</th>
                        <th class="px-5 py-3">Registered</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800/60 text-neutral-300">
                    @foreach($recentBusinesses as $b)
                        <tr class="hover:bg-neutral-850/50 transition">
                            <td class="px-5 py-3.5 font-medium text-white">{{ $b->name }}</td>
                            <td class="px-5 py-3.5">
                                <div>{{ $b->owner_name }}</div>
                                <div class="text-[11px] text-neutral-500">{{ $b->owner_email }}</div>
                            </td>
                            <td class="px-5 py-3.5 font-mono text-[11px] text-neutral-400">
                                TIN: {{ $b->tin ?: '—' }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold uppercase {{ $b->status === 'active' ? 'bg-emerald-950 text-emerald-400 border border-emerald-800/60' : 'bg-red-950 text-red-400 border border-red-800/60' }}">
                                    {{ $b->status }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold uppercase bg-neutral-800 text-neutral-300">
                                    {{ $b->subscription_status }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 font-mono text-[11px] text-neutral-400">
                                {{ $b->created_at->format('Y-m-d') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
