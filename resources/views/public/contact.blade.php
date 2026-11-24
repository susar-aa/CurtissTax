@extends('layouts.public')

@section('title', __('app.nav_contact') . ' – ' . __('app.brand'))
@section('meta_description', __('app.contact_subtitle'))

@section('content')
<div class="relative overflow-hidden pt-12 pb-24 lg:pt-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-4">
            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-neutral-900 border border-neutral-800 text-neutral-300">
                <i data-lucide="send" class="w-3.5 h-3.5 text-white"></i>
                <span>CurtissTax</span>
            </div>
            <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-white">
                {{ __('app.contact_title') }}
            </h1>
            <p class="text-base text-neutral-400">
                {{ __('app.contact_subtitle') }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Contact Details Cards -->
            <div class="space-y-6 lg:col-span-1">
                <div class="p-6 rounded-2xl bg-neutral-900/60 border border-neutral-800 space-y-2">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-neutral-800 flex items-center justify-center text-white">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                        </div>
                        <h2 class="text-sm font-bold text-white">{{ __('app.contact_office_title') }}</h2>
                    </div>
                    <p class="text-xs text-neutral-400 leading-relaxed pl-12">
                        CurtissTax Technologies, Level 12, World Trade Center, Colombo 01, Sri Lanka
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-neutral-900/60 border border-neutral-800 space-y-2">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-neutral-800 flex items-center justify-center text-white">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        <h2 class="text-sm font-bold text-white">{{ __('app.contact_email_title') }}</h2>
                    </div>
                    <p class="text-xs text-neutral-400 leading-relaxed pl-12 font-mono">
                        support@taxinvoice.trycurtiss.com
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-neutral-900/60 border border-neutral-800 space-y-2">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-neutral-800 flex items-center justify-center text-white">
                            <i data-lucide="phone" class="w-4 h-4"></i>
                        </div>
                        <h2 class="text-sm font-bold text-white">{{ __('app.contact_phone_title') }}</h2>
                    </div>
                    <p class="text-xs text-neutral-400 leading-relaxed pl-12 font-mono">
                        +94 (11) 234-5678 / +94 (77) 123-4567
                    </p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2 p-8 sm:p-10 rounded-3xl bg-neutral-900/60 border border-neutral-800 space-y-6">
                <div>
                    <h2 class="text-lg font-bold text-white">{{ __('app.contact_form_title') }}</h2>
                    <p class="text-xs text-neutral-400 mt-1">Our support team responds within one business day.</p>
                </div>

                <form action="#" method="POST" class="space-y-4" onsubmit="event.preventDefault(); alert('{{ __('app.contact_msg_sent') }}');">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-neutral-300 mb-1.5">Your Name</label>
                            <input type="text"
                                   required
                                   placeholder="e.g. Priyantha Silva"
                                   class="w-full px-3.5 py-2.5 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs placeholder-neutral-600 focus:outline-none focus:border-neutral-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-300 mb-1.5">Business Email</label>
                            <input type="email"
                                   required
                                   placeholder="priyantha@example.lk"
                                   class="w-full px-3.5 py-2.5 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs placeholder-neutral-600 focus:outline-none focus:border-neutral-500 transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-neutral-300 mb-1.5">Phone Number</label>
                            <input type="tel"
                                   placeholder="+94 77 123 4567"
                                   class="w-full px-3.5 py-2.5 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs placeholder-neutral-600 focus:outline-none focus:border-neutral-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-300 mb-1.5">{{ __('app.business_name') }}</label>
                            <input type="text"
                                   placeholder="Your Business / Trading Name"
                                   class="w-full px-3.5 py-2.5 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs placeholder-neutral-600 focus:outline-none focus:border-neutral-500 transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-neutral-300 mb-1.5">Message / Inquiry</label>
                        <textarea rows="4"
                                  required
                                  placeholder="How can we assist your business?"
                                  class="w-full px-3.5 py-2.5 rounded-lg bg-neutral-950 border border-neutral-800 text-white text-xs placeholder-neutral-600 focus:outline-none focus:border-neutral-500 transition"></textarea>
                    </div>

                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-white text-neutral-950 font-semibold hover:bg-neutral-200 transition text-xs shadow">
                        <span>{{ __('app.contact_send_btn') }}</span>
                        <i data-lucide="send" class="w-3.5 h-3.5"></i>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
