@extends('layouts.app')

@section('title', __('app.nav_team') . ' – ' . __('app.brand'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-800 pb-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">{{ __('app.team_members') }}</h1>
            <p class="text-xs text-neutral-400 mt-1">Manage employee access, role permissions, and pending invitations for {{ $business->name }}.</p>
        </div>
    </div>

    <!-- Invite Member Box -->
    <div class="bg-neutral-900/80 border border-neutral-800 rounded-xl p-5 space-y-4">
        <h3 class="text-xs font-semibold uppercase tracking-wider text-white flex items-center space-x-2">
            <i data-lucide="mail-plus" class="w-4 h-4 text-neutral-400"></i>
            <span>{{ __('app.invite_member') }}</span>
        </h3>

        <form action="{{ route('app.team.invite') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
            @csrf
            <div>
                <label class="block text-xs font-medium text-neutral-300 mb-1">{{ __('app.email') }} *</label>
                <input type="email" name="email" required placeholder="colleague@yourcompany.lk"
                       class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-medium text-neutral-300 mb-1">{{ __('app.role') }} *</label>
                <select name="role" class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                    <option value="admin">{{ __('app.role_admin') }}</option>
                    <option value="accountant">{{ __('app.role_accountant') }}</option>
                    <option value="staff" selected>{{ __('app.role_staff') }}</option>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full py-2 px-4 rounded-lg bg-white text-neutral-950 font-semibold text-xs hover:bg-neutral-200 transition shadow-sm">
                    Send Invitation
                </button>
            </div>
        </form>
    </div>

    <!-- Active Team Members Table -->
    <div class="bg-neutral-900/80 border border-neutral-800 rounded-xl overflow-hidden">
        <div class="px-5 py-4 border-b border-neutral-800">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-white">Active Members ({{ $members->total() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-neutral-950/60 text-neutral-400 uppercase tracking-wider text-[11px] border-b border-neutral-800">
                    <tr>
                        <th class="px-5 py-3 font-semibold">User</th>
                        <th class="px-5 py-3 font-semibold">{{ __('app.role') }}</th>
                        <th class="px-5 py-3 font-semibold">{{ __('app.status') }}</th>
                        <th class="px-5 py-3 font-semibold">Language</th>
                        <th class="px-5 py-3 font-semibold">Joined Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800/60 text-neutral-300">
                    @foreach($members as $m)
                        <tr class="hover:bg-neutral-850/50 transition">
                            <td class="px-5 py-3.5">
                                <div class="font-medium text-white">{{ $m->name }}</div>
                                <div class="text-[11px] text-neutral-400">{{ $m->email }}</div>
                            </td>
                            <td class="px-5 py-3.5">
                                @if($m->is_owner)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-amber-950 text-amber-300 border border-amber-800/60">
                                        {{ __('app.role_owner') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-neutral-800 text-neutral-200 border border-neutral-700">
                                        {{ ucfirst($m->role) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-emerald-950 text-emerald-400 border border-emerald-800/60">
                                    {{ __('app.active') }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 uppercase font-mono text-[11px] text-neutral-400">
                                {{ $m->locale ?: 'en' }}
                            </td>
                            <td class="px-5 py-3.5 text-neutral-400 font-mono text-[11px]">
                                {{ $m->joined_at ? \Carbon\Carbon::parse($m->joined_at)->format('Y-m-d') : '—' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($members->hasPages())
            <div class="px-5 py-3 border-t border-neutral-800">
                {{ $members->links() }}
            </div>
        @endif
    </div>

    <!-- Pending Invitations -->
    @if($pendingInvitations->isNotEmpty())
        <div class="bg-neutral-900/80 border border-neutral-800 rounded-xl overflow-hidden">
            <div class="px-5 py-3 border-b border-neutral-800">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-amber-400">{{ __('app.pending_invitations') }}</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-neutral-950/60 text-neutral-400 uppercase tracking-wider text-[11px] border-b border-neutral-800">
                        <tr>
                            <th class="px-5 py-2.5">Invited Email</th>
                            <th class="px-5 py-2.5">Role</th>
                            <th class="px-5 py-2.5">Invited By</th>
                            <th class="px-5 py-2.5">Expires</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-800/60 text-neutral-300">
                        @foreach($pendingInvitations as $inv)
                            <tr>
                                <td class="px-5 py-3 font-medium text-white">{{ $inv->email }}</td>
                                <td class="px-5 py-3">{{ ucfirst($inv->role) }}</td>
                                <td class="px-5 py-3 text-neutral-400">{{ $inv->inviter_name }}</td>
                                <td class="px-5 py-3 text-neutral-400 font-mono text-[11px]">
                                    {{ \Carbon\Carbon::parse($inv->expires_at)->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
