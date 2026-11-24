@extends('layouts.public')

@section('title', __('app.brand') . ' – ' . __('app.hero_title_lead') . ' ' . __('app.hero_title_accent'))
@section('meta_description', __('app.hero_subtitle'))

@section('content')
<div class="relative overflow-hidden pt-12 pb-24 lg:pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24">

        {{-- Hero Section --}}
        <section class="text-center max-w-4xl mx-auto space-y-6">
            <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full text-xs font-medium bg-neutral-900 border border-neutral-800 text-neutral-300">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>{{ __('app.hero_badge') }}</span>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight">
                {{ __('app.hero_title_lead') }} <br>
                <span class="text-neutral-400">{{ __('app.hero_title_accent') }}</span>
            </h1>

            <p class="text-base sm:text-lg text-neutral-400 max-w-2xl mx-auto leading-relaxed">
                {{ __('app.hero_subtitle') }}
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                <a href="{{ route('register') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-lg bg-white text-neutral-950 font-semibold hover:bg-neutral-200 transition shadow-lg text-center">
                    <span>{{ __('app.hero_cta_primary') }}</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
                <a href="#sample-invoice"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg bg-neutral-900 border border-neutral-800 text-neutral-300 hover:text-white hover:border-neutral-700 transition text-center">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                    <span>{{ __('app.hero_cta_secondary') }}</span>
                </a>
            </div>

            <div class="pt-2 text-xs text-neutral-500">
                {{ __('app.hero_trial_note') }}
            </div>
        </section>

        {{-- Interactive Realistic Tax Invoice Sample Section --}}
        <section id="sample-invoice" class="scroll-mt-24 space-y-8" x-data="{ docType: 'vat' }">
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-neutral-900 border border-neutral-800 text-neutral-400">
                    <i data-lucide="printer" class="w-3.5 h-3.5 text-emerald-400"></i>
                    <span>{{ __('app.sample_badge') }}</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                    {{ __('app.sample_title') }}
                </h2>
                <p class="text-sm text-neutral-400">
                    {{ __('app.sample_desc') }}
                </p>
                <div class="flex items-center justify-center gap-3 pt-2">
                    <button type="button"
                            @click="docType = 'vat'"
                            :class="docType === 'vat' ? 'bg-white text-neutral-950 font-semibold' : 'bg-neutral-900 text-neutral-400 hover:text-white border border-neutral-800'"
                            class="px-4 py-1.5 rounded-lg text-xs transition">
                        {{ __('app.vat_title') }}
                    </button>
                    <button type="button"
                            @click="docType = 'non_vat'"
                            :class="docType === 'non_vat' ? 'bg-white text-neutral-950 font-semibold' : 'bg-neutral-900 text-neutral-400 hover:text-white border border-neutral-800'"
                            class="px-4 py-1.5 rounded-lg text-xs transition">
                        {{ __('app.non_vat_title') }}
                    </button>
                </div>
            </div>

            <!-- Tax Invoice Paper Container -->
            <div class="max-w-4xl mx-auto bg-neutral-900/90 rounded-2xl border border-neutral-800 p-6 sm:p-10 shadow-2xl backdrop-blur-sm">
                <!-- Invoice Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start gap-6 border-b border-neutral-800 pb-8">
                    <div>
                        <div class="inline-block px-2.5 py-1 rounded text-xs font-mono font-semibold tracking-wider uppercase mb-3"
                             :class="docType === 'vat' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : 'bg-blue-500/10 text-blue-400 border border-blue-500/30'">
                            <span x-show="docType === 'vat'">{{ __('app.sample_tax_invoice') }}</span>
                            <span x-show="docType === 'non_vat'" style="display: none;">COMMERCIAL INVOICE</span>
                        </div>
                        <h3 class="text-xl font-bold text-white">Lanka Precision Engineering (Pvt) Ltd</h3>
                        <p class="text-xs text-neutral-400 mt-1">No. 142/A, Galle Road, Colombo 03, Sri Lanka</p>
                        <div class="flex flex-wrap gap-x-4 gap-y-1 mt-2 text-xs font-mono text-neutral-400">
                            <span>TIN: <strong class="text-neutral-200">102938475</strong></span>
                            <span>BRN: <strong class="text-neutral-200">PV-123456</strong></span>
                            <span x-show="docType === 'vat'">VAT: <strong class="text-emerald-400">102938475-7000</strong></span>
                        </div>
                    </div>

                    <div class="text-left sm:text-right font-mono text-xs space-y-1 text-neutral-400">
                        <div>{{ __('app.sample_inv_no') }}: <span class="font-bold text-white text-sm">CTX-2026-0042</span></div>
                        <div>{{ __('app.sample_date') }}: <span class="text-neutral-200">2026-11-24</span></div>
                        <div>Due Date: <span class="text-neutral-200">2026-12-08</span></div>
                        <div class="text-[11px] text-neutral-500">Currency: LKR (Rs.)</div>
                    </div>
                </div>

                <!-- Bill To -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 py-6 border-b border-neutral-800 text-xs">
                    <div>
                        <span class="text-neutral-500 uppercase tracking-wider font-semibold block mb-1">{{ __('app.sample_customer') }}</span>
                        <div class="font-bold text-white text-sm">Ceylon Industrial Works PLC</div>
                        <div class="text-neutral-400 mt-0.5">88 High Level Road, Maharagama</div>
                        <div class="text-neutral-400 mt-1 font-mono">TIN: 108472910 | VAT: 108472910-7000</div>
                    </div>
                    <div class="sm:text-right">
                        <span class="text-neutral-500 uppercase tracking-wider font-semibold block mb-1">{{ __('app.sample_original_buyer') }}</span>
                        <div class="text-neutral-300">Inland Revenue Act No. 24 of 2017</div>
                        <div class="text-emerald-400 font-mono text-[11px] mt-0.5">Valid Sequential Number Record ✓</div>
                    </div>
                </div>

                <!-- Line Items Table -->
                <div class="overflow-x-auto py-6">
                    <table class="w-full text-left text-xs">
                        <thead class="text-neutral-500 uppercase tracking-wider border-b border-neutral-800">
                            <tr>
                                <th class="pb-3 font-semibold">#</th>
                                <th class="pb-3 font-semibold">{{ __('app.sample_item') }}</th>
                                <th class="pb-3 font-semibold text-right">{{ __('app.sample_qty') }}</th>
                                <th class="pb-3 font-semibold text-right">{{ __('app.sample_rate') }}</th>
                                <th x-show="docType === 'vat'" class="pb-3 font-semibold text-right">{{ __('app.sample_vat_rate') }}</th>
                                <th class="pb-3 font-semibold text-right">{{ __('app.sample_total') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-800/60 font-mono text-neutral-300">
                            <tr>
                                <td class="py-3 text-neutral-500">1</td>
                                <td class="py-3 font-sans">
                                    <div class="font-medium text-white">Precision CNC Machining Service</div>
                                    <div class="text-[11px] text-neutral-500">Custom flange manufacturing for turbine unit #3</div>
                                </td>
                                <td class="py-3 text-right">10</td>
                                <td class="py-3 text-right">15,000.00</td>
                                <td x-show="docType === 'vat'" class="py-3 text-right text-emerald-400">18%</td>
                                <td class="py-3 text-right font-semibold text-white">150,000.00</td>
                            </tr>
                            <tr>
                                <td class="py-3 text-neutral-500">2</td>
                                <td class="py-3 font-sans">
                                    <div class="font-medium text-white">Industrial Surface Finishing & Coating</div>
                                    <div class="text-[11px] text-neutral-500">Anti-corrosive primer and zinc thermal spray</div>
                                </td>
                                <td class="py-3 text-right">1</td>
                                <td class="py-3 text-right">45,000.00</td>
                                <td x-show="docType === 'vat'" class="py-3 text-right text-emerald-400">18%</td>
                                <td class="py-3 text-right font-semibold text-white">45,000.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Totals Breakdown -->
                <div class="flex flex-col sm:flex-row justify-between items-start pt-6 border-t border-neutral-800 gap-6">
                    <div class="max-w-md text-xs text-neutral-400 space-y-2">
                        <div class="text-neutral-300 font-semibold">Compliance Note:</div>
                        <p class="text-[11px] text-neutral-500 leading-relaxed" x-show="docType === 'vat'">
                            Official Tax Invoice under Sri Lanka Value Added Tax Act No. 14 of 2002.
                        </p>
                        <p class="text-[11px] text-neutral-500 leading-relaxed" x-show="docType === 'non_vat'" style="display: none;">
                            Commercial Invoice by non-VAT registered entity. No input tax may be claimed.
                        </p>
                    </div>

                    <div class="w-full sm:w-72 font-mono text-xs space-y-2.5">
                        <div class="flex justify-between text-neutral-400">
                            <span>{{ __('app.sample_subtotal') }}:</span>
                            <span class="text-white">LKR 195,000.00</span>
                        </div>
                        <div class="flex justify-between text-neutral-400" x-show="docType === 'vat'">
                            <span>{{ __('app.sample_vat_amount') }} (18%):</span>
                            <span class="text-emerald-400">+ LKR 35,100.00</span>
                        </div>
                        <div class="flex justify-between text-neutral-400" x-show="docType === 'non_vat'" style="display: none;">
                            <span>VAT:</span>
                            <span class="text-neutral-500">N/A</span>
                        </div>
                        <div class="border-t border-neutral-800 pt-3 flex justify-between text-sm font-bold text-white">
                            <span>{{ __('app.sample_total') }}:</span>
                            <span x-show="docType === 'vat'" class="text-emerald-400 text-base">LKR 230,100.00</span>
                            <span x-show="docType === 'non_vat'" class="text-white text-base" style="display: none;">LKR 195,000.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- How It Works --}}
        <section id="how-it-works" class="space-y-12">
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-neutral-900 border border-neutral-800 text-neutral-400">
                    <i data-lucide="zap" class="w-3.5 h-3.5 text-amber-400"></i>
                    <span>3 Steps</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                    {{ __('app.hiw_title') }}
                </h2>
                <p class="text-sm text-neutral-400">
                    {{ __('app.hiw_subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 rounded-2xl bg-neutral-900/60 border border-neutral-800 relative hover:border-neutral-700 transition">
                    <div class="text-4xl font-bold font-mono text-neutral-700 mb-4">01</div>
                    <h3 class="text-lg font-semibold text-white mb-2">{{ __('app.step1_title') }}</h3>
                    <p class="text-sm text-neutral-400 leading-relaxed">{{ __('app.step1_desc') }}</p>
                </div>
                <div class="p-8 rounded-2xl bg-neutral-900/60 border border-neutral-800 relative hover:border-neutral-700 transition">
                    <div class="text-4xl font-bold font-mono text-neutral-700 mb-4">02</div>
                    <h3 class="text-lg font-semibold text-white mb-2">{{ __('app.step2_title') }}</h3>
                    <p class="text-sm text-neutral-400 leading-relaxed">{{ __('app.step2_desc') }}</p>
                </div>
                <div class="p-8 rounded-2xl bg-neutral-900/60 border border-neutral-800 relative hover:border-neutral-700 transition">
                    <div class="text-4xl font-bold font-mono text-neutral-700 mb-4">03</div>
                    <h3 class="text-lg font-semibold text-white mb-2">{{ __('app.step3_title') }}</h3>
                    <p class="text-sm text-neutral-400 leading-relaxed">{{ __('app.step3_desc') }}</p>
                </div>
            </div>
        </section>

        {{-- VAT vs Non-VAT Comparison Section --}}
        <section class="space-y-12">
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-neutral-900 border border-neutral-800 text-neutral-400">
                    <i data-lucide="scale" class="w-3.5 h-3.5 text-blue-400"></i>
                    <span>Compliance</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                    {{ __('app.vat_section_title') }}
                </h2>
                <p class="text-sm text-neutral-400">
                    {{ __('app.vat_section_subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- VAT Registered Card -->
                <div class="p-8 rounded-2xl bg-neutral-900/60 border border-emerald-500/30 hover:border-emerald-500/50 transition space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold">
                            <i data-lucide="badge-check" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-400">{{ __('app.vat_badge') }}</span>
                            <h3 class="text-lg font-bold text-white">{{ __('app.vat_title') }}</h3>
                        </div>
                    </div>
                    <p class="text-xs text-neutral-400">{{ __('app.vat_desc') }}</p>
                    <ul class="space-y-3 text-xs text-neutral-300">
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                            <span>{{ __('app.vat_item1') }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                            <span>{{ __('app.vat_item2') }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                            <span>{{ __('app.vat_item3') }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                            <span>{{ __('app.vat_item4') }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Non-VAT Card -->
                <div class="p-8 rounded-2xl bg-neutral-900/60 border border-neutral-800 hover:border-neutral-700 transition space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-neutral-800 text-neutral-300 flex items-center justify-center font-bold">
                            <i data-lucide="calculator" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-neutral-400">{{ __('app.non_vat_badge') }}</span>
                            <h3 class="text-lg font-bold text-white">{{ __('app.non_vat_title') }}</h3>
                        </div>
                    </div>
                    <p class="text-xs text-neutral-400">{{ __('app.non_vat_desc') }}</p>
                    <ul class="space-y-3 text-xs text-neutral-300">
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-neutral-400 flex-shrink-0"></i>
                            <span>{{ __('app.non_vat_item1') }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-neutral-400 flex-shrink-0"></i>
                            <span>{{ __('app.non_vat_item2') }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-neutral-400 flex-shrink-0"></i>
                            <span>{{ __('app.non_vat_item3') }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-neutral-400 flex-shrink-0"></i>
                            <span>{{ __('app.non_vat_item4') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- Dynamic Pricing Preview --}}
        <section id="pricing" class="space-y-12" x-data="{ annual: false }">
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-neutral-900 border border-neutral-800 text-neutral-400">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-white"></i>
                    <span>{{ __('app.pricing_title') }}</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                    {{ __('app.pricing_title') }}
                </h2>
                <p class="text-sm text-neutral-400">
                    {{ __('app.pricing_subtitle') }}
                </p>

                <!-- Billing Toggle -->
                <div class="flex items-center justify-center gap-3 pt-4">
                    <span :class="!annual ? 'text-white font-semibold' : 'text-neutral-500'" class="text-xs cursor-pointer" @click="annual = false">{{ __('app.pricing_monthly') }}</span>
                    <button type="button"
                            @click="annual = !annual"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-neutral-800 transition-colors duration-200 ease-in-out focus:outline-none"
                            :class="annual ? 'bg-white' : 'bg-neutral-800'"
                            role="switch">
                        <span aria-hidden="true"
                              class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-neutral-950 shadow ring-0 transition duration-200 ease-in-out"
                              :class="annual ? 'translate-x-5 bg-neutral-950' : 'translate-x-0 bg-neutral-400'"></span>
                    </button>
                    <span :class="annual ? 'text-white font-semibold' : 'text-neutral-500'" class="text-xs cursor-pointer flex items-center gap-1.5" @click="annual = true">
                        <span>{{ __('app.pricing_annually') }}</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">{{ __('app.pricing_save_tag') }}</span>
                    </span>
                </div>
            </div>

            <!-- Dynamic Plans Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($plans as $plan)
                <div class="p-8 rounded-2xl bg-neutral-900/60 border {{ $plan->slug === 'professional' ? 'border-neutral-400 ring-1 ring-neutral-400/50' : 'border-neutral-800' }} hover:border-neutral-700 transition flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-white">{{ $plan->name }}</h3>
                            @if($plan->slug === 'professional')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-white text-neutral-950">Most Popular</span>
                            @endif
                        </div>
                        <p class="text-xs text-neutral-400">{{ $plan->description }}</p>

                        <div class="pt-2">
                            <div class="flex items-baseline gap-1">
                                <span class="text-xs text-neutral-400 font-mono">LKR</span>
                                <span class="text-3xl font-extrabold text-white font-mono" x-show="!annual">
                                    {{ number_format($plan->price_lkr_monthly, 0) }}
                                </span>
                                <span class="text-3xl font-extrabold text-white font-mono" x-show="annual" style="display: none;">
                                    {{ number_format($plan->price_lkr_annually / 12, 0) }}
                                </span>
                                <span class="text-xs text-neutral-500"> {{ __('app.per_month') }}</span>
                            </div>
                            <div class="text-[11px] text-neutral-500 mt-1" x-show="annual" style="display: none;">
                                Billed LKR {{ number_format($plan->price_lkr_annually, 0) }} {{ __('app.per_year') }}
                            </div>
                        </div>

                        <div class="border-t border-neutral-800 pt-4 space-y-2.5 text-xs text-neutral-300">
                            <div class="flex items-center gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-emerald-400"></i>
                                <span>{{ $plan->max_users }} {{ $plan->max_users == 1 ? 'Team Member' : 'Team Members' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-emerald-400"></i>
                                <span>{{ $plan->max_invoices_per_month }} Invoices per month</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-emerald-400"></i>
                                <span>{{ $plan->max_branches }} {{ $plan->max_branches == 1 ? 'Branch Location' : 'Branches' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-emerald-400"></i>
                                <span>Trilingual Output (EN, SI, TA)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-emerald-400"></i>
                                <span>Full Audit Trails & Security</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('register') }}"
                       class="w-full py-2.5 px-4 rounded-lg text-center text-xs font-semibold transition {{ $plan->slug === 'professional' ? 'bg-white text-neutral-950 hover:bg-neutral-200 shadow' : 'bg-neutral-800 text-white hover:bg-neutral-700' }}">
                        {{ __('app.nav_register') }}
                    </a>
                </div>
                @endforeach
            </div>
        </section>

        {{-- FAQ Section (Accordion with Alpine.js) --}}
        <section id="faq" class="space-y-8 max-w-4xl mx-auto" x-data="{ active: null }">
            <div class="text-center space-y-3">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-neutral-900 border border-neutral-800 text-neutral-400">
                    <i data-lucide="help-circle" class="w-3.5 h-3.5 text-neutral-300"></i>
                    <span>FAQ</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                    {{ __('app.faq_title') }}
                </h2>
                <p class="text-sm text-neutral-400">
                    {{ __('app.faq_subtitle') }}
                </p>
            </div>

            <div class="space-y-4">
                @php
                    $faqs = [
                        ['q' => __('app.faq_q1'), 'a' => __('app.faq_a1')],
                        ['q' => __('app.faq_q2'), 'a' => __('app.faq_a2')],
                        ['q' => __('app.faq_q3'), 'a' => __('app.faq_a3')],
                        ['q' => __('app.faq_q4'), 'a' => __('app.faq_a4')],
                        ['q' => __('app.faq_q5'), 'a' => __('app.faq_a5')],
                    ];
                @endphp

                @foreach($faqs as $idx => $faq)
                <div class="rounded-xl border border-neutral-800 bg-neutral-900/60 overflow-hidden">
                    <button type="button"
                            @click="active = (active === {{ $idx }} ? null : {{ $idx }})"
                            class="w-full px-6 py-4 text-left flex items-center justify-between text-white font-medium text-sm hover:bg-neutral-800/40 transition">
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
        </section>

        {{-- Final CTA Banner --}}
        <section class="rounded-3xl bg-neutral-900 border border-neutral-800 p-8 sm:p-12 text-center space-y-6">
            <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                {{ __('app.hero_cta_primary') }}
            </h2>
            <p class="text-sm text-neutral-400 max-w-xl mx-auto">
                {{ __('app.hero_trial_note') }}
            </p>
            <div class="pt-2">
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-2 px-8 py-3.5 rounded-lg bg-white text-neutral-950 font-semibold hover:bg-neutral-200 transition shadow-lg text-sm">
                    <span>{{ __('app.nav_register') }}</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </section>

    </div>
</div>
@endsection
