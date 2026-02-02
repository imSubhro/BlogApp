<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blogs - {{ config('app.name', 'BlogApp') }}</title>
    <meta name="description" content="Browse all published blogs from our community of writers. Discover stories, ideas, and insights.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ route('blogs.public') }}">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Blogs - {{ config('app.name', 'BlogApp') }}">
    <meta property="og:description" content="Browse all published blogs from our community of writers.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('blogs.public') }}">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Blogs - {{ config('app.name', 'BlogApp') }}">
    <meta name="twitter:description" content="Browse all published blogs from our community of writers.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center space-x-2">
                            <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="text-xl font-bold text-gray-900">BlogApp</span>
                        </a>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('blogs.public') }}" class="text-indigo-600 font-medium">Blogs</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition">Log in</a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                                Get Started
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Header -->
        <div class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">All Blogs</h1>
                        <p class="text-lg text-gray-600">Discover stories and ideas from our community of writers.</p>
                    </div>
                    
                    <!-- Search Form -->
                    <form action="{{ route('blogs.public') }}" method="GET" class="flex-shrink-0">
                        <div class="relative">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Search blogs..."
                                class="w-full md:w-80 pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            >
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            @if(request('search'))
                                <a href="{{ route('blogs.public') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                
                @if(request('search'))
                    <p class="mt-4 text-gray-600">
                        Showing results for "<span class="font-semibold">{{ request('search') }}</span>"
                        <span class="text-gray-400">- {{ $blogs->total() }} {{ Str::plural('result', $blogs->total()) }}</span>
                    </p>
                @endif
            </div>
        </div>

        <!-- Blog List -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            @if($blogs->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($blogs as $blog)
                        <article class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
                            <!-- Featured Image -->
                            <a href="{{ route('blogs.single', $blog->slug) }}" class="block overflow-hidden">
                                @if($blog->featured_image)
                                    <img 
                                        src="{{ asset('storage/' . $blog->featured_image) }}" 
                                        alt="{{ $blog->title }}" 
                                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center group-hover:from-indigo-600 group-hover:to-purple-700 transition-all duration-300">
                                        <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            
                            <!-- Content -->
                            <div class="p-6">
                                <a href="{{ route('blogs.single', $blog->slug) }}">
                                    <h2 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors line-clamp-2">
                                        {{ $blog->title }}
                                    </h2>
                                </a>
                                
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ $blog->excerpt ?: $blog->shortExcerpt }}
                                </p>
                                
                                <!-- Author & Date -->
                                <div class="flex items-center justify-between text-sm border-t border-gray-100 pt-4">
                                    <a href="{{ route('blogs.by-author', $blog->user_id) }}" class="flex items-center hover:text-indigo-600 transition">
                                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-sm">
                                            {{ strtoupper(substr($blog->user->name, 0, 1)) }}
                                        </div>
                                        <span class="ml-2 text-gray-700 font-medium">{{ $blog->user->name }}</span>
                                    </a>
                                    <span class="text-gray-500">{{ $blog->published_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-12">
                    {{ $blogs->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20">
                    @if(request('search'))
                        <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <h2 class="text-2xl font-semibold text-gray-700 mb-3">No results found</h2>
                        <p class="text-gray-500 mb-8 max-w-md mx-auto">
                            We couldn't find any blogs matching "{{ request('search') }}". Try a different search term.
                        </p>
                        <a href="{{ route('blogs.public') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition">
                            Clear Search
                        </a>
                    @else
                        <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <h2 class="text-2xl font-semibold text-gray-700 mb-3">No blogs published yet</h2>
                        <p class="text-gray-500 mb-8 max-w-md mx-auto">Be the first to share your story with the world!</p>
                        @guest
                            <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition shadow-lg">
                                Start Writing Today
                            </a>
                        @else
                            <a href="{{ route('blogs.create') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition shadow-lg">
                                Create Your First Blog
                            </a>
                        @endguest
                    @endif
                </div>
            @endif
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t py-8 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-600">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'BlogApp') }}. Built with Laravel & Tailwind CSS.</p>
            </div>
        </footer>
    </div>
</body>
</html>
