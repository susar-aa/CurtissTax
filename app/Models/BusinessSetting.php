<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'financial_year_start_month',
        'default_tax_rate',
        'invoice_prefix',
        'invoice_next_number',
        'invoice_footer_notes',
        'invoice_terms',
        'invoice_locale',
        'show_bank_details',
        'bank_name',
        'bank_branch',
        'bank_account_name',
        'bank_account_number',
        'bank_swift_code',
    ];

    protected $casts = [
        'default_tax_rate' => 'decimal:2',
        'show_bank_details' => 'boolean',
        'invoice_next_number' => 'integer',
        'financial_year_start_month' => 'integer',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
