<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Trilingual PDF Font Configuration (English, Sinhala, Tamil)
    |--------------------------------------------------------------------------
    |
    | Sri Lankan Tax Invoices generated via PDF engines (DomPDF / mPDF / Browsershot)
    | require embedded Unicode TrueType fonts (.ttf) for proper rendering of Sinhala
    | (U+0D80–U+0DFF) and Tamil (U+0B80–U+0BFF) characters. Without embedded Unicode
    | fonts, PDF engines will produce replacement glyphs (???? / □□□).
    |
    */

    'font_dir' => storage_path('fonts/'),
    'font_cache' => storage_path('fonts/cache/'),

    'fonts' => [
        'sinhala' => [
            'name' => 'Noto Sans Sinhala',
            'regular' => 'NotoSansSinhala-Regular.ttf',
            'bold' => 'NotoSansSinhala-Bold.ttf',
            'fallback' => 'iskpota.ttf',
        ],
        'tamil' => [
            'name' => 'Noto Sans Tamil',
            'regular' => 'NotoSansTamil-Regular.ttf',
            'bold' => 'NotoSansTamil-Bold.ttf',
            'fallback' => 'latha.ttf',
        ],
        'english' => [
            'name' => 'Inter',
            'regular' => 'Inter-Regular.ttf',
            'bold' => 'Inter-Bold.ttf',
            'fallback' => 'Helvetica',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Document Settings
    |--------------------------------------------------------------------------
    */
    'default_paper_size' => 'a4',
    'default_orientation' => 'portrait',
    'default_currency_symbol' => 'LKR',
    'enable_unicode' => true,
    'dpi' => 150,
];
