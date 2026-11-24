<!DOCTYPE html>
<html lang="{{ $locale ?? 'en' }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@yield('title', 'Document')</title>
    <style>
        /* PDF Trilingual Unicode Font Styles */
        @font-face {
            font-family: 'Noto Sans Sinhala';
            font-style: normal;
            font-weight: 400;
            src: url('{{ storage_path('fonts/NotoSansSinhala-Regular.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'Noto Sans Sinhala';
            font-style: normal;
            font-weight: 700;
            src: url('{{ storage_path('fonts/NotoSansSinhala-Bold.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'Noto Sans Tamil';
            font-style: normal;
            font-weight: 400;
            src: url('{{ storage_path('fonts/NotoSansTamil-Regular.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'Noto Sans Tamil';
            font-style: normal;
            font-weight: 700;
            src: url('{{ storage_path('fonts/NotoSansTamil-Bold.ttf') }}') format('truetype');
        }

        body {
            font-family: 'Inter', 'Noto Sans Sinhala', 'Noto Sans Tamil', DejaVu Sans, sans-serif;
            font-size: 11pt;
            color: #0f172a;
            line-height: 1.4;
            margin: 0;
            padding: 20mm 15mm;
        }

        .header-table, .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table th, .items-table td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
        }

        .items-table th {
            background-color: #f1f5f9;
            font-weight: bold;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
    </style>
    @stack('pdf-styles')
</head>
<body>
    @yield('content')
</body>
</html>
