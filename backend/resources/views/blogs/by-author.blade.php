<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $author ? $author->name . "'s Blogs" : 'Author' }} - {{ config('app.name', 'BlogApp') }}</title>
    <meta name="description" content="Browse all published blogs by {{ $author?->name ?? 'this author' }}.">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph -->
    <meta property="og:title" content="{{ $author?->name ?? 'Author' }}'s Blogs - {{ config('app.name', 'BlogApp') }}">
    <meta property="og:description" content="Discover articles and stories by {{ $author?->name ?? 'this author' }}">
    <meta property="og:type" content="profile">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
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
                    <a href="{{ route('blogs.public') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition">All Blogs</a>
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

    @if($author)
        <!-- Hero Section with Author Profile -->
        <div class="relative overflow-hidden">
            <!-- Animated Gradient Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
            </div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
                <!-- Back Link -->
                <a href="{{ route('blogs.public') }}" class="inline-flex items-center text-white/80 hover:text-white mb-8 transition group text-sm">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to All Blogs
                </a>
                
                <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                    <!-- Author Avatar -->
                    <div class="relative">
                        <div class="w-32 h-32 md:w-40 md:h-40 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-5xl md:text-6xl font-bold text-white shadow-2xl ring-4 ring-white/30">
                            {{ strtoupper(substr($author->name, 0, 1)) }}
                        </div>
                        <!-- Online indicator -->
                        <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-400 rounded-full border-4 border-white shadow-lg"></div>
                    </div>
                    
                    <!-- Author Info -->
                    <div class="text-center md:text-left flex-1">
                        <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 tracking-tight">
                            {{ $author->name }}
                        </h1>
                        <p class="text-white/80 text-lg mb-6 max-w-xl">
                            Passionate writer sharing insights and stories with the community.
                        </p>
                        
                        <!-- Stats Cards -->
                        <div class="flex flex-wrap justify-center md:justify-start gap-4 mb-6">
                            <div class="bg-white/10 backdrop-blur-md rounded-xl px-5 py-3 text-center border border-white/20">
                                <div class="text-3xl font-bold text-white">{{ $blogs->total() }}</div>
                                <div class="text-sm text-white/70">{{ Str::plural('Article', $blogs->total()) }}</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-md rounded-xl px-5 py-3 text-center border border-white/20">
                                <div class="text-3xl font-bold text-white">
                                    {{ $blogs->sum(function($blog) { return ceil(str_word_count($blog->content) / 200); }) }}
                                </div>
                                <div class="text-sm text-white/70">Min Read Total</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-md rounded-xl px-5 py-3 text-center border border-white/20">
                                <div class="text-3xl font-bold text-white">
                                    {{ $author->created_at->diffForHumans(null, true) }}
                                </div>
                                <div class="text-sm text-white/70">Member Since</div>
                            </div>
                        </div>
                        
                        <!-- Social/Follow Actions -->
                        <div class="flex flex-wrap justify-center md:justify-start gap-3">
                            <button class="inline-flex items-center px-6 py-2.5 bg-white text-indigo-600 font-semibold rounded-full hover:bg-indigo-50 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                Follow Author
                            </button>
                            <button class="inline-flex items-center px-5 py-2.5 bg-white/10 text-white font-medium rounded-full hover:bg-white/20 transition border border-white/30">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                </svg>
                                Share Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Wave Separator -->
            <div class="absolute bottom-0 left-0 right-0">
                <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#F9FAFB"/>
                </svg>
            </div>
        </div>

        <!-- Blog List Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Section Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Published Articles</h2>
                    <p class="text-gray-500 mt-1">Latest stories and insights from {{ $author->name }}</p>
                </div>
                <div class="hidden md:flex items-center gap-2">
                    <span class="text-sm text-gray-500">Sort by:</span>
                    <select class="text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <option>Latest First</option>
                        <option>Oldest First</option>
                        <option>Most Read</option>
                    </select>
                </div>
            </div>
            
            @if($blogs->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($blogs as $blog)
                        <article class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group border border-gray-100">
                            <!-- Featured Image -->
                            <a href="{{ route('blogs.single', $blog->slug) }}" class="block overflow-hidden relative">
                                @if($blog->featured_image)
                                    <img 
                                        src="{{ asset('storage/' . $blog->featured_image) }}" 
                                        alt="{{ $blog->title }}" 
                                        class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-500"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="h-52 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center group-hover:from-indigo-600 group-hover:via-purple-600 group-hover:to-pink-600 transition-all duration-500">
                                        <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Overlay Gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                
                                <!-- Read Time Badge -->
                                <div class="absolute top-4 right-4 bg-black/60 backdrop-blur-sm text-white text-xs font-medium px-3 py-1 rounded-full">
                                    {{ ceil(str_word_count($blog->content) / 200) }} min read
                                </div>
                            </a>
                            
                            <!-- Content -->
                            <div class="p-6">
                                <!-- Category Badge -->
                                @if($blog->category)
                                    <a href="{{ route('blogs.by-category', $blog->category->slug) }}" 
                                       class="inline-block px-3 py-1 text-xs font-semibold rounded-full mb-3 transition hover:opacity-80"
                                       style="background-color: {{ $blog->category->color }}15; color: {{ $blog->category->color }};">
                                        {{ $blog->category->name }}
                                    </a>
                                @endif
                                
                                <a href="{{ route('blogs.single', $blog->slug) }}">
                                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors line-clamp-2 leading-tight">
                                        {{ $blog->title }}
                                    </h3>
                                </a>
                                
                                <p class="text-gray-500 mb-4 line-clamp-2 text-sm leading-relaxed">
                                    {{ $blog->excerpt ?: $blog->shortExcerpt }}
                                </p>
                                
                                <!-- Tags -->
                                @if($blog->tags && $blog->tags->count() > 0)
                                    <div class="flex flex-wrap gap-1.5 mb-4">
                                        @foreach($blog->tags->take(3) as $tag)
                                            <a href="{{ route('blogs.by-tag', $tag->slug) }}" 
                                               class="px-2 py-0.5 text-xs rounded-full transition hover:opacity-80"
                                               style="background-color: {{ $tag->color }}20; color: {{ $tag->color }};">
                                                #{{ $tag->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <!-- Footer -->
                                <div class="flex items-center justify-between text-sm border-t border-gray-100 pt-4">
                                    <time class="text-gray-400" datetime="{{ $blog->published_at->toIso8601String() }}">
                                        {{ $blog->published_at->format('M d, Y') }}
                                    </time>
                                    <a href="{{ route('blogs.single', $blog->slug) }}" class="inline-flex items-center text-indigo-600 font-medium hover:text-indigo-700 transition group/link">
                                        Read More
                                        <svg class="w-4 h-4 ml-1 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
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
                <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">No articles yet</h2>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">{{ $author->name }} hasn't published any articles yet. Check back later for new content!</p>
                    <a href="{{ route('blogs.public') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Explore All Blogs
                    </a>
                </div>
            @endif
        </div>
    @else
        <!-- Author Not Found -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Author Not Found</h1>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">The author you're looking for doesn't exist or has no published content.</p>
                <a href="{{ route('blogs.public') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition">
                    Browse All Blogs
                </a>
            </div>
        </div>
    @endif

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 text-white">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span class="text-xl font-bold">BlogApp</span>
                </a>
                <div class="flex items-center gap-6 text-sm">
                    <a href="{{ route('blogs.public') }}" class="hover:text-white transition">All Blogs</a>
                    <a href="#" class="hover:text-white transition">About</a>
                    <a href="#" class="hover:text-white transition">Contact</a>
                </div>
                <p class="text-sm">&copy; {{ date('Y') }} {{ config('app.name', 'BlogApp') }}. Built with love by imSubhro</p>
            </div>
        </div>
    </footer>
</body>
</html>
