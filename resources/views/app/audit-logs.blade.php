@extends('layouts.app')

@section('title', __('app.nav_audit_logs') . ' – ' . __('app.brand'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-800 pb-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">{{ __('app.nav_audit_logs') }}</h1>
            <p class="text-xs text-neutral-400 mt-1">Immutable security and operational event trail for {{ $business->name }}.</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-neutral-900/80 border border-neutral-800 rounded-xl p-4">
        <form method="GET" action="{{ route('app.audit-logs.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="w-48">
                <select name="event" class="w-full px-3 py-1.5 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                    <option value="">All Events</option>
                    <option value="business_registered" {{ request('event') === 'business_registered' ? 'selected' : '' }}>Business Registered</option>
                    <option value="business_settings_updated" {{ request('event') === 'business_settings_updated' ? 'selected' : '' }}>Settings Updated</option>
                    <option value="invitation_created" {{ request('event') === 'invitation_created' ? 'selected' : '' }}>Invitation Created</option>
                    <option value="invitation_accepted" {{ request('event') === 'invitation_accepted' ? 'selected' : '' }}>Invitation Accepted</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-1.5 rounded-lg bg-neutral-800 hover:bg-neutral-700 text-white text-xs font-medium transition">
                Filter
            </button>
            @if(request()->has('event'))
                <a href="{{ route('app.audit-logs.index') }}" class="text-xs text-neutral-400 hover:text-white">Clear</a>
            @endif
        </form>
    </div>

    <!-- Logs Table -->
    <div class="bg-neutral-900/80 border border-neutral-800 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-neutral-950/60 text-neutral-400 uppercase tracking-wider text-[11px] border-b border-neutral-800">
                    <tr>
                        <th class="px-5 py-3">Event</th>
                        <th class="px-5 py-3">Entity</th>
                        <th class="px-5 py-3">User</th>
                        <th class="px-5 py-3">IP Address</th>
                        <th class="px-5 py-3">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800/60 text-neutral-300">
                    @forelse($logs as $log)
                        <tr class="hover:bg-neutral-850/50 transition">
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-mono font-medium bg-neutral-800 text-neutral-200">
                                    {{ $log->event }}
                                </span>
                            </td>
                            <td class="px-5 py-3 font-mono text-[11px] text-neutral-400">
                                {{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}
                            </td>
                            <td class="px-5 py-3">
                                <div class="font-medium text-white">{{ $log->user_name ?: 'System' }}</div>
                                @if($log->user_email)
                                    <div class="text-[11px] text-neutral-500">{{ $log->user_email }}</div>
                                @endif
                            </td>
                            <td class="px-5 py-3 font-mono text-[11px] text-neutral-500">
                                {{ $log->ip_address ?: '127.0.0.1' }}
                            </td>
                            <td class="px-5 py-3 font-mono text-[11px] text-neutral-400">
                                {{ $log->created_at->format('Y-m-d H:i:s') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-xs text-neutral-500">
                                No audit log records found matching criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="px-5 py-3 border-t border-neutral-800">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
