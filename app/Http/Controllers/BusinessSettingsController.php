<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Business;
use App\Models\BusinessSetting;
use Illuminate\Http\Request;

class BusinessSettingsController extends Controller
{
    public function index()
    {
        $business = app('current_business');

        if (!auth()->user()->hasPermission('business.view', $business->id)) {
            abort(403, __('app.unauthorized_permission'));
        }

        $settings = $business->settings ?: BusinessSetting::firstOrCreate(['business_id' => $business->id]);

        return view('app.settings', compact('business', 'settings'));
    }

    public function update(Request $request)
    {
        $business = app('current_business');

        if (!auth()->user()->hasPermission('settings.manage', $business->id)) {
            abort(403, __('app.unauthorized_permission'));
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'legal_name' => ['nullable', 'string', 'max:255'],
            'registration_number' => ['nullable', 'string', 'max:50'],
            'tin' => ['nullable', 'string', 'max:50'],
            'vat_number' => ['nullable', 'string', 'max:50'],
            'is_vat_registered' => ['nullable', 'boolean'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'address_line1' => ['nullable', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'financial_year_start_month' => ['required', 'integer', 'between:1,12'],
            'default_tax_rate' => ['required', 'numeric', 'between:0,100'],
            'invoice_prefix' => ['required', 'string', 'max:20'],
            'invoice_locale' => ['required', 'in:en,si,ta'],
            'invoice_footer_notes' => ['nullable', 'string', 'max:1000'],
            'invoice_terms' => ['nullable', 'string', 'max:1000'],
            'show_bank_details' => ['nullable', 'boolean'],
            'bank_name' => ['nullable', 'string', 'max:100'],
            'bank_branch' => ['nullable', 'string', 'max:100'],
            'bank_account_name' => ['nullable', 'string', 'max:100'],
            'bank_account_number' => ['nullable', 'string', 'max:50'],
            'bank_swift_code' => ['nullable', 'string', 'max:30'],
        ]);

        $oldBusinessValues = $business->only(['name', 'legal_name', 'tin', 'vat_number', 'is_vat_registered']);

        $business->update([
            'name' => $validated['name'],
            'legal_name' => $validated['legal_name'] ?? $validated['name'],
            'registration_number' => $validated['registration_number'] ?? null,
            'tin' => $validated['tin'] ?? null,
            'vat_number' => $validated['vat_number'] ?? null,
            'is_vat_registered' => $request->boolean('is_vat_registered'),
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'address_line1' => $validated['address_line1'] ?? null,
            'address_line2' => $validated['address_line2'] ?? null,
            'city' => $validated['city'] ?? null,
            'district' => $validated['district'] ?? null,
            'province' => $validated['province'] ?? null,
        ]);

        $settings = $business->settings ?: new BusinessSetting(['business_id' => $business->id]);
        $settings->fill([
            'financial_year_start_month' => $validated['financial_year_start_month'],
            'default_tax_rate' => $validated['default_tax_rate'],
            'invoice_prefix' => $validated['invoice_prefix'],
            'invoice_locale' => $validated['invoice_locale'],
            'invoice_footer_notes' => $validated['invoice_footer_notes'] ?? null,
            'invoice_terms' => $validated['invoice_terms'] ?? null,
            'show_bank_details' => $request->boolean('show_bank_details'),
            'bank_name' => $validated['bank_name'] ?? null,
            'bank_branch' => $validated['bank_branch'] ?? null,
            'bank_account_name' => $validated['bank_account_name'] ?? null,
            'bank_account_number' => $validated['bank_account_number'] ?? null,
            'bank_swift_code' => $validated['bank_swift_code'] ?? null,
        ])->save();

        AuditLog::log('business_settings_updated', $business, $oldBusinessValues, $business->only(['name', 'tin', 'vat_number']));

        return redirect()->route('app.settings.index')
            ->with('success', __('app.save') . ' - ' . __('app.active'));
    }
}
