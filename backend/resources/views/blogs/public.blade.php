<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blogs - {{ config('app.name', 'BlogApp') }}</title>
    <meta name="description" content="Discover amazing articles and stories from our community.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white border-b sticky top-0 z-50">
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
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition">Dashboard</a>
                        <a href="{{ route('blogs.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Write
                        </a>
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">All Blogs</h1>
                    <p class="text-gray-500 mt-1">Discover stories and ideas from our community</p>
                </div>
                
                <!-- Search -->
                <form action="{{ route('blogs.public') }}" method="GET" class="w-full md:w-auto">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Search blogs..."
                            class="w-full md:w-80 pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        >
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Blog Grid -->
            <div class="flex-1">
                @if(request('search'))
                    <div class="mb-6 flex items-center justify-between bg-white rounded-lg px-4 py-3 border border-gray-100">
                        <p class="text-gray-600">
                            Results for "<span class="font-medium text-gray-900">{{ request('search') }}</span>"
                            <span class="text-gray-400">({{ $blogs->total() }} found)</span>
                        </p>
                        <a href="{{ route('blogs.public') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Clear</a>
                    </div>
                @endif

                @if($blogs->count() > 0)
                    <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-6">
                        @foreach($blogs as $blog)
                            <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                                <!-- Thumbnail -->
                                <a href="{{ route('blogs.single', $blog->slug) }}" class="block relative h-48 bg-gradient-to-br from-indigo-500 to-purple-500">
                                    @if($blog->featured_image)
                                        <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-12 h-12 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Category Badge -->
                                    @if($blog->category)
                                        <div class="absolute top-3 left-3">
                                            <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-white/90 backdrop-blur-sm" style="color: {{ $blog->category->color }};">
                                                {{ $blog->category->name }}
                                            </span>
                                        </div>
                                    @endif
                                </a>
                                
                                <!-- Content -->
                                <div class="p-5">
                                    <a href="{{ route('blogs.single', $blog->slug) }}">
                                        <h2 class="font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-indigo-600 transition">
                                            {{ $blog->title }}
                                        </h2>
                                    </a>
                                    <p class="text-sm text-gray-500 line-clamp-2 mb-4">
                                        {{ $blog->excerpt ?: $blog->shortExcerpt }}
                                    </p>
                                    
                                    <!-- Tags -->
                                    @if($blog->tags && $blog->tags->count() > 0)
                                        <div class="flex flex-wrap gap-1.5 mb-4">
                                            @foreach($blog->tags->take(3) as $tag)
                                                <a href="{{ route('blogs.by-tag', $tag->slug) }}" 
                                                   class="px-2 py-0.5 text-xs rounded-full transition hover:opacity-80"
                                                   style="background-color: {{ $tag->color }}15; color: {{ $tag->color }};">
                                                    #{{ $tag->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <!-- Meta -->
                                    <div class="flex items-center justify-between text-sm pt-4 border-t border-gray-100">
                                        <a href="{{ route('blogs.by-author', $blog->user->id) }}" class="flex items-center text-gray-500 hover:text-indigo-600 transition">
                                            <div class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center text-xs font-medium text-gray-600 mr-2">
                                                {{ strtoupper(substr($blog->user->name, 0, 1)) }}
                                            </div>
                                            {{ $blog->user->name }}
                                        </a>
                                        <span class="text-gray-400">{{ $blog->published_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $blogs->withQueryString()->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16 bg-white rounded-xl border border-gray-100">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No blogs found</h3>
                        <p class="text-gray-500 mb-6">{{ request('search') ? 'Try a different search term.' : 'Be the first to share something!' }}</p>
                        @auth
                            <a href="{{ route('blogs.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Write a Blog
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <aside class="lg:w-72 flex-shrink-0 space-y-6">
                <!-- Categories -->
                @if(isset($categories) && $categories->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                        <h3 class="font-semibold text-gray-900 mb-4">Categories</h3>
                        <div class="space-y-2">
                            @foreach($categories as $category)
                                <a href="{{ route('blogs.by-category', $category->slug) }}" class="flex items-center justify-between py-2 px-3 rounded-lg hover:bg-gray-50 transition group">
                                    <span class="flex items-center text-sm">
                                        <span class="w-2.5 h-2.5 rounded-full mr-2.5" style="background-color: {{ $category->color }};"></span>
                                        <span class="text-gray-600 group-hover:text-gray-900 transition">{{ $category->name }}</span>
                                    </span>
                                    <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">{{ $category->blogs_count ?? 0 }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Popular Tags -->
                @if(isset($popularTags) && $popularTags->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                        <h3 class="font-semibold text-gray-900 mb-4">Popular Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($popularTags as $tag)
                                <a href="{{ route('blogs.by-tag', $tag->slug) }}" 
                                   class="px-3 py-1.5 text-xs font-medium rounded-full transition hover:shadow-sm"
                                   style="background-color: {{ $tag->color }}15; color: {{ $tag->color }}; border: 1px solid {{ $tag->color }}30;">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t py-8 mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'BlogApp') }}. Built with love by imSubhro.</p>
        </div>
    </footer>
</body>
</html>
