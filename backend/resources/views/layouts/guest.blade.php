<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BlogApp') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(5deg); }
            }
            @keyframes float-reverse {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(20px) rotate(-5deg); }
            }
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }
            .animate-float-reverse {
                animation: float-reverse 8s ease-in-out infinite;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center p-4 sm:p-6 lg:p-8 relative overflow-hidden gradient-bg">
            <!-- Decorative Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-10 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl animate-float"></div>
                <div class="absolute top-1/3 right-10 w-96 h-96 bg-purple-300/20 rounded-full blur-3xl animate-float-reverse"></div>
                <div class="absolute bottom-10 left-1/4 w-64 h-64 bg-pink-300/20 rounded-full blur-3xl animate-float"></div>
                <div class="absolute bottom-1/4 right-1/4 w-48 h-48 bg-indigo-300/20 rounded-full blur-3xl animate-float-reverse"></div>
            </div>

            <!-- Logo -->
            <div class="relative z-10 mb-8">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-white drop-shadow-lg">BlogApp</span>
                </a>
            </div>

            <!-- Card -->
            <div class="w-full sm:max-w-md relative z-10">
                <div class="glass-card shadow-2xl rounded-3xl overflow-hidden">
                    <div class="px-8 py-10 sm:px-10">
                        {{ $slot }}
                    </div>
                </div>
                
                <!-- Back to Home Link -->
                <div class="mt-6 text-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Home
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="relative z-10 mt-8 text-center text-white/60 text-sm">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'BlogApp') }}. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
