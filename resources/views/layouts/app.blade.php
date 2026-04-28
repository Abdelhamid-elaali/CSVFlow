<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CSV Flow') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">
        <!-- Modern Navigation -->
        <nav class="nav-modern">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('csv.index') }}" class="logo flex items-center gap-2">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                style="-webkit-text-fill-color: initial;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    stroke="url(#gradient)" />
                                <defs>
                                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" style="stop-color:#667eea" />
                                        <stop offset="100%" style="stop-color:#764ba2" />
                                    </linearGradient>
                                </defs>
                            </svg>
                            CSVFlow
                        </a>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('csv.index') }}" class="nav-link">Upload</a>
                        <a href="{{ route('csv.verify') }}" class="nav-link">Verify</a>
                    </div>
                </div>
            </div>
        </nav>

        @if (isset($header))
            <header class="page-header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main class="animate-fade-in">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="mt-auto py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm" style="color: rgba(255, 255, 255, 0.4);">
                    © {{ date('Y') }} CSVFlow — Modern CSV Data Management
                </p>
            </div>
        </footer>
    </div>
    @stack('scripts')
</body>

</html>