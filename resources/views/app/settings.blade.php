@extends('layouts.app')

@section('title', __('app.nav_settings') . ' – ' . __('app.brand'))

@section('content')
<div class="space-y-6 max-w-4xl">
    <div class="border-b border-neutral-800 pb-4">
        <h1 class="text-2xl font-bold tracking-tight text-white">{{ __('app.nav_settings') }}</h1>
        <p class="text-xs text-neutral-400 mt-1">Configure your official Sri Lankan business profile, tax registration details, and invoicing defaults.</p>
    </div>

    @if ($errors->any())
        <div class="p-4 rounded-lg bg-red-950/70 border border-red-800 text-red-300 text-xs space-y-1">
            @foreach ($errors->all() as $error)
                <div class="flex items-center space-x-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                    <span>{{ $error }}</span>
                </div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('app.settings.update') }}" method="POST" class="space-y-8">
        @csrf

        <!-- Section 1: Business Profile -->
        <div class="bg-neutral-900/80 border border-neutral-800 rounded-xl p-6 space-y-5">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-white border-b border-neutral-800 pb-3 flex items-center space-x-2">
                <i data-lucide="building" class="w-4 h-4 text-neutral-400"></i>
                <span>1. {{ __('app.business_profile') }}</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.business_name') }} *</label>
                    <input type="text" name="name" value="{{ old('name', $business->name) }}" required
                           class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.legal_name') }}</label>
                    <input type="text" name="legal_name" value="{{ old('legal_name', $business->legal_name) }}"
                           class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.registration_number') }}</label>
                    <input type="text" name="registration_number" value="{{ old('registration_number', $business->registration_number) }}"
                           class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none"
                           placeholder="PV00000000">
                </div>
                <div>
                    <label class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.tin') }}</label>
                    <input type="text" name="tin" value="{{ old('tin', $business->tin) }}"
                           class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none"
                           placeholder="102938475">
                </div>
                <div>
                    <label class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.vat_number') }}</label>
                    <input type="text" name="vat_number" value="{{ old('vat_number', $business->vat_number) }}"
                           class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none"
                           placeholder="102938475-7000">
                </div>
            </div>

            <div class="pt-2">
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="is_vat_registered" name="is_vat_registered" value="1"
                           {{ old('is_vat_registered', $business->is_vat_registered) ? 'checked' : '' }}
                           class="rounded bg-neutral-950 border-neutral-800 text-white focus:ring-neutral-700">
                    <label for="is_vat_registered" class="text-xs text-neutral-200 font-semibold cursor-pointer">
                        {{ __('app.is_vat_registered') }}
                    </label>
                </div>
                <p class="text-[11px] text-neutral-400 mt-1 pl-6">
                    {{ __('app.vat_registered_help') }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.phone') }}</label>
                    <input type="text" name="phone" value="{{ old('phone', $business->phone) }}"
                           class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.email') }}</label>
                    <input type="email" name="email" value="{{ old('email', $business->email) }}"
                           class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.address') }}</label>
                    <input type="text" name="address_line1" value="{{ old('address_line1', $business->address_line1) }}"
                           class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.city') }}</label>
                    <input type="text" name="city" value="{{ old('city', $business->city) }}"
                           class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                </div>
            </div>
        </div>

        <!-- Section 2: Invoice & Tax Rules -->
        <div class="bg-neutral-900/80 border border-neutral-800 rounded-xl p-6 space-y-5">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-white border-b border-neutral-800 pb-3 flex items-center space-x-2">
                <i data-lucide="receipt" class="w-4 h-4 text-neutral-400"></i>
                <span>2. Tax Invoicing Rules & Defaults</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-medium text-neutral-300 mb-1.5">Financial Year Start Month *</label>
                    <select name="financial_year_start_month" class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                        <option value="4" {{ old('financial_year_start_month', $settings->financial_year_start_month) == 4 ? 'selected' : '' }}>April (Sri Lanka Standard)</option>
                        <option value="1" {{ old('financial_year_start_month', $settings->financial_year_start_month) == 1 ? 'selected' : '' }}>January (Calendar Year)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.tax_rate') }} *</label>
                    <input type="number" step="0.01" name="default_tax_rate" value="{{ old('default_tax_rate', $settings->default_tax_rate) }}" required
                           class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.invoice_prefix') }} *</label>
                    <input type="text" name="invoice_prefix" value="{{ old('invoice_prefix', $settings->invoice_prefix) }}" required
                           class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                </div>
            </div>

            <!-- Independent Invoice Output Language -->
            <div class="p-4 rounded-lg bg-neutral-950 border border-neutral-800 space-y-2">
                <label class="block text-xs font-semibold text-white">{{ __('app.invoice_language') }} *</label>
                <p class="text-[11px] text-neutral-400">{{ __('app.invoice_language_help') }}</p>
                <div class="flex flex-wrap gap-4 pt-1">
                    <label class="flex items-center space-x-2 text-xs text-neutral-300 cursor-pointer">
                        <input type="radio" name="invoice_locale" value="en" {{ old('invoice_locale', $settings->invoice_locale) === 'en' ? 'checked' : '' }}
                               class="bg-neutral-900 border-neutral-800 text-white focus:ring-neutral-700">
                        <span>English (Default)</span>
                    </label>
                    <label class="flex items-center space-x-2 text-xs text-neutral-300 cursor-pointer">
                        <input type="radio" name="invoice_locale" value="si" {{ old('invoice_locale', $settings->invoice_locale) === 'si' ? 'checked' : '' }}
                               class="bg-neutral-900 border-neutral-800 text-white focus:ring-neutral-700">
                        <span>සිංහල (Sinhala)</span>
                    </label>
                    <label class="flex items-center space-x-2 text-xs text-neutral-300 cursor-pointer">
                        <input type="radio" name="invoice_locale" value="ta" {{ old('invoice_locale', $settings->invoice_locale) === 'ta' ? 'checked' : '' }}
                               class="bg-neutral-900 border-neutral-800 text-white focus:ring-neutral-700">
                        <span>தமிழ் (Tamil)</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-neutral-300 mb-1.5">Invoice Footer Notes</label>
                <textarea name="invoice_footer_notes" rows="2"
                          class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">{{ old('invoice_footer_notes', $settings->invoice_footer_notes) }}</textarea>
            </div>
        </div>

        <!-- Section 3: Bank Account Details -->
        <div class="bg-neutral-900/80 border border-neutral-800 rounded-xl p-6 space-y-5">
            <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-white flex items-center space-x-2">
                    <i data-lucide="landmark" class="w-4 h-4 text-neutral-400"></i>
                    <span>3. {{ __('app.bank_details') }}</span>
                </h2>
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="show_bank_details" name="show_bank_details" value="1"
                           {{ old('show_bank_details', $settings->show_bank_details) ? 'checked' : '' }}
                           class="rounded bg-neutral-950 border-neutral-800 text-white focus:ring-neutral-700">
                    <label for="show_bank_details" class="text-xs text-neutral-300 cursor-pointer">Show on printed invoices</label>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.bank_name') }}</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name', $settings->bank_name) }}"
                           class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none"
                           placeholder="e.g. Commercial Bank of Ceylon">
                </div>
                <div>
                    <label class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.bank_branch') }}</label>
                    <input type="text" name="bank_branch" value="{{ old('bank_branch', $settings->bank_branch) }}"
                           class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none"
                           placeholder="e.g. Kollupitiya">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.bank_account_name') }}</label>
                    <input type="text" name="bank_account_name" value="{{ old('bank_account_name', $settings->bank_account_name) }}"
                           class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.bank_account_number') }}</label>
                    <input type="text" name="bank_account_number" value="{{ old('bank_account_number', $settings->bank_account_number) }}"
                           class="w-full px-3 py-2 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs focus:ring-2 focus:ring-neutral-700 focus:outline-none">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="px-6 py-2.5 rounded-lg bg-white text-neutral-950 font-bold text-xs hover:bg-neutral-200 transition shadow-md">
                {{ __('app.save') }}
            </button>
        </div>
    </form>
</div>
@endsection
