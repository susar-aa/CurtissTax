@extends('layouts.public')

@section('title', __('auth.register_title') . ' – ' . __('app.brand'))

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8 max-w-2xl mx-auto">
    <div class="bg-neutral-900/90 border border-neutral-800 p-8 rounded-2xl shadow-2xl space-y-8">
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-white text-neutral-950 font-bold text-xl mb-1">
                C
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-white">{{ __('auth.register_title') }}</h2>
            <p class="text-xs text-amber-400 font-medium">
                {{ __('auth.register_subtitle') }}
            </p>
        </div>

        @if ($errors->any())
            <div class="p-3.5 rounded-lg bg-red-950/70 border border-red-800 text-red-300 text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <div class="flex items-center space-x-2">
                        <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <form class="space-y-6" action="{{ route('register') }}" method="POST">
            @csrf

            <!-- User Info Section -->
            <div class="space-y-4">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-neutral-400 border-b border-neutral-800 pb-2">
                    1. Account Owner Information
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('auth.name_label') }} *</label>
                        <input id="name" name="name" type="text" required value="{{ old('name') }}"
                               class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none"
                               placeholder="e.g. Kasun Fernando">
                    </div>
                    <div>
                        <label for="phone" class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.phone') }}</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                               class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none"
                               placeholder="+94 77 123 4567">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('auth.email_label') }} *</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                           class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none"
                           placeholder="owner@yourcompany.lk">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('auth.password_label') }} *</label>
                        <input id="password" name="password" type="password" required
                               class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('auth.password_confirm_label') }} *</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                               class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- Business Info Section -->
            <div class="space-y-4 pt-2">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-neutral-400 border-b border-neutral-800 pb-2">
                    2. Business Tax Profile
                </h3>

                <div>
                    <label for="business_name" class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.business_name') }} *</label>
                    <input id="business_name" name="business_name" type="text" required value="{{ old('business_name') }}"
                           class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none"
                           placeholder="e.g. Ceylon Agro Solutions">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="tin" class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.tin') }}</label>
                        <input id="tin" name="tin" type="text" value="{{ old('tin') }}"
                               class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none"
                               placeholder="e.g. 102938475">
                    </div>
                    <div>
                        <label for="vat_number" class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.vat_number') }}</label>
                        <input id="vat_number" name="vat_number" type="text" value="{{ old('vat_number') }}"
                               class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none"
                               placeholder="e.g. 102938475-7000">
                    </div>
                </div>

                <div class="flex items-center space-x-2 pt-1">
                    <input type="checkbox" id="is_vat_registered" name="is_vat_registered" value="1" {{ old('is_vat_registered') ? 'checked' : '' }}
                           class="rounded bg-neutral-950 border-neutral-800 text-white focus:ring-neutral-700">
                    <label for="is_vat_registered" class="text-xs text-neutral-300 font-medium cursor-pointer">
                        {{ __('app.is_vat_registered') }}
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="city" class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.city') }}</label>
                        <input id="city" name="city" type="text" value="{{ old('city') }}"
                               class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none"
                               placeholder="e.g. Colombo 03">
                    </div>
                    <div>
                        <label for="invoice_locale" class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.invoice_language') }}</label>
                        <select id="invoice_locale" name="invoice_locale"
                                class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                            <option value="en">English (Default)</option>
                            <option value="si">Sinhala (සිංහල)</option>
                            <option value="ta">Tamil (தமிழ்)</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit"
                    class="w-full py-3 px-4 rounded-lg bg-white text-neutral-950 font-bold text-xs hover:bg-neutral-200 transition shadow-lg mt-6">
                {{ __('auth.register_button') }} (14 Days Free)
            </button>

            <div class="text-center text-xs text-neutral-500">
                {{ __('auth.have_account') }}
                <a href="{{ route('login') }}" class="font-medium text-white hover:underline">{{ __('auth.sign_in_button') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
