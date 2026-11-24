@extends('layouts.public')

@section('title', __('app.terms_title') . ' – ' . __('app.brand'))

@section('content')
<div class="relative overflow-hidden pt-12 pb-24 lg:pt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <div class="text-center space-y-3">
            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-white">{{ __('app.terms_title') }}</h1>
            <p class="text-xs text-neutral-400">{{ __('app.terms_last_updated') }}</p>
        </div>

        <div class="prose prose-invert max-w-none text-xs sm:text-sm text-neutral-300 space-y-8 rounded-3xl bg-neutral-900/60 border border-neutral-800 p-8 sm:p-12 leading-relaxed">
            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">1. Agreement to Terms</h2>
                <p class="text-neutral-400">
                    These Terms and Conditions constitute a legally binding agreement made between you, whether personally or on behalf of an entity ("you", "User"), and CurtissTax ("we", "us", "our"), concerning your access to and use of the CurtissTax website and software platform located at <span class="font-mono text-neutral-300">taxinvoice.trycurtiss.com</span>.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">2. Sri Lankan Regulatory & Invoicing Compliance</h2>
                <p class="text-neutral-400">
                    CurtissTax provides business software designed to assist Sri Lankan businesses in issuing tax invoices and maintaining billing records in alignment with the Value Added Tax Act No. 14 of 2002 (as amended) and Inland Revenue Act No. 24 of 2017. Users are solely responsible for ensuring that their tax registration status, Taxpayer Identification Numbers (TIN), VAT registration numbers, and tax declarations accurately represent their lawful standing with the Department of Inland Revenue (IRD) Sri Lanka.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">3. Multi-Tenant Account & Ownership Structure</h2>
                <p class="text-neutral-400">
                    In accordance with CurtissTax platform architecture, one registered user account may own exactly one business entity. You may invite multiple authorized employees to your tenant organization subject to the seat limits of your subscription plan. You agree to protect account credentials and maintain responsibility for all activities occurring under your business organization.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">4. 14-Day Free Trial & Subscriptions</h2>
                <p class="text-neutral-400">
                    New business accounts receive an automatic 14-day free trial granting full access to system features without requiring payment card information. Upon trial expiry, the platform enters read-only mode to preserve your historical financial records until an active subscription tier is chosen. We do not delete your financial records upon trial expiration.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">5. Governing Law</h2>
                <p class="text-neutral-400">
                    These Terms shall be governed by and defined following the laws of the Democratic Socialist Republic of Sri Lanka. CurtissTax and yourself irrevocably consent that the courts of Sri Lanka shall have exclusive jurisdiction to resolve any dispute.
                </p>
            </section>
        </div>

    </div>
</div>
@endsection
