@extends('layouts.admin')

@section('title', __('app.admin_businesses') . ' – ' . __('app.brand'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-800 pb-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">{{ __('app.admin_businesses') }}</h1>
            <p class="text-xs text-neutral-400 mt-1">Directory of all businesses registered on the CurtissTax platform.</p>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-neutral-900 border border-neutral-800 rounded-xl p-4">
        <form method="GET" action="{{ route('admin.businesses.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search business name..."
                       class="w-full px-3 py-1.5 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
            </div>
            <div class="w-36">
                <select name="status" class="w-full px-3 py-1.5 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
            <div class="w-40">
                <select name="subscription" class="w-full px-3 py-1.5 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                    <option value="">All Subscriptions</option>
                    <option value="trial" {{ request('subscription') === 'trial' ? 'selected' : '' }}>Trial</option>
                    <option value="active" {{ request('subscription') === 'active' ? 'selected' : '' }}>Subscribed</option>
                    <option value="expired" {{ request('subscription') === 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-1.5 rounded-lg bg-neutral-800 hover:bg-neutral-700 text-white text-xs font-medium transition">
                Search
            </button>
            @if(request()->anyFilled(['search', 'status', 'subscription']))
                <a href="{{ route('admin.businesses.index') }}" class="text-xs text-neutral-400 hover:text-white">Reset</a>
            @endif
        </form>
    </div>

    <!-- Businesses Table -->
    <div class="bg-neutral-900 border border-neutral-800 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-neutral-950/60 text-neutral-400 uppercase tracking-wider text-[11px] border-b border-neutral-800">
                    <tr>
                        <th class="px-5 py-3">Business</th>
                        <th class="px-5 py-3">Owner Contact</th>
                        <th class="px-5 py-3">Tax Status</th>
                        <th class="px-5 py-3">Plan</th>
                        <th class="px-5 py-3">Trial / Expiry</th>
                        <th class="px-5 py-3">Account Status</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800/60 text-neutral-300">
                    @forelse($businesses as $b)
                        <tr class="hover:bg-neutral-850/50 transition">
                            <td class="px-5 py-3.5">
                                <div class="font-medium text-white">{{ $b->name }}</div>
                                <div class="font-mono text-[10px] text-neutral-500">{{ $b->uuid }}</div>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="text-neutral-200">{{ $b->owner_name }}</div>
                                <div class="text-[11px] text-neutral-500">{{ $b->owner_email }}</div>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="font-mono text-[11px] text-neutral-300">TIN: {{ $b->tin ?: 'None' }}</div>
                                <div class="text-[10px] text-neutral-500">{{ $b->is_vat_registered ? 'VAT Registered' : 'Non-VAT' }}</div>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-neutral-800 text-neutral-300">
                                    {{ $b->plan_name ?: 'Free Trial' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 font-mono text-[11px]">
                                @if($b->subscription_status === 'trial')
                                    <span class="text-amber-400">Trial to {{ $b->trial_ends_at ? \Carbon\Carbon::parse($b->trial_ends_at)->format('Y-m-d') : '—' }}</span>
                                @else
                                    <span class="text-neutral-400">{{ ucfirst($b->subscription_status) }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold uppercase {{ $b->status === 'active' ? 'bg-emerald-950 text-emerald-400 border border-emerald-800/60' : 'bg-red-950 text-red-400 border border-red-800/60' }}">
                                    {{ $b->status }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <form action="{{ route('admin.businesses.toggle-status', $b->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 rounded text-[11px] font-medium transition {{ $b->status === 'active' ? 'bg-red-950 hover:bg-red-900 text-red-300 border border-red-800/60' : 'bg-emerald-950 hover:bg-emerald-900 text-emerald-300 border border-emerald-800/60' }}">
                                        {{ $b->status === 'active' ? 'Suspend' : 'Activate' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-xs text-neutral-500">
                                No businesses found matching query.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($businesses->hasPages())
            <div class="px-5 py-3 border-t border-neutral-800">
                {{ $businesses->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
