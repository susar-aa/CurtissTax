@extends('layouts.public')

@section('title', __('app.privacy_title') . ' – ' . __('app.brand'))

@section('content')
<div class="relative overflow-hidden pt-12 pb-24 lg:pt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <div class="text-center space-y-3">
            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-white">{{ __('app.privacy_title') }}</h1>
            <p class="text-xs text-neutral-400">{{ __('app.privacy_last_updated') }}</p>
        </div>

        <div class="prose prose-invert max-w-none text-xs sm:text-sm text-neutral-300 space-y-8 rounded-3xl bg-neutral-900/60 border border-neutral-800 p-8 sm:p-12 leading-relaxed">
            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">1. Commitment to Business Privacy</h2>
                <p class="text-neutral-400">
                    At CurtissTax, we take the confidentiality of your financial records and customer data with paramount seriousness. This Privacy Policy details the types of information collected through our tax invoicing platform and how that data is safeguarded under strict multi-tenant isolation.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">2. Data We Collect</h2>
                <ul class="list-disc list-inside text-neutral-400 space-y-1.5">
                    <li><strong class="text-white">Account Information:</strong> Name, business email, contact phone number, and encrypted credentials.</li>
                    <li><strong class="text-white">Business Entity Data:</strong> Business registration number (BRN), Taxpayer Identification Number (TIN), VAT registration details, registered business address, and logo.</li>
                    <li><strong class="text-white">Billing & Document Data:</strong> Customer contact details, invoice line items, amounts, and audit trail timestamps.</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">3. Multi-Tenant Isolation & Security</h2>
                <p class="text-neutral-400">
                    CurtissTax implements strict architectural database tenant scoping (<span class="font-mono text-neutral-300">business_id</span> enforcement on all tenant models) and cryptographically separated session tokens. No business user or organization can view, query, or mutate financial data belonging to another business.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">4. Data Retention & Read-Only Access</h2>
                <p class="text-neutral-400">
                    In compliance with Sri Lankan tax record retention standards, your business invoices and client history remain stored securely. When a trial or subscription expires, records transition to secure read-only mode and are never sold, rented, or distributed to third parties.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">5. Contact Our Data Protection Officer</h2>
                <p class="text-neutral-400">
                    If you have questions regarding data privacy, security, or wish to request data export, contact our compliance team at <span class="font-mono text-neutral-300">privacy@taxinvoice.trycurtiss.com</span>.
                </p>
            </section>
        </div>

    </div>
</div>
@endsection
