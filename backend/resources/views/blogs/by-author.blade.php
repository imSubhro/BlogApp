<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $author ? $author->name . "'s Blogs" : 'Author' }} - {{ config('app.name', 'BlogApp') }}</title>
    <meta name="description" content="Browse all published blogs by {{ $author?->name ?? 'this author' }}.">
    <meta name="robots" content="index, follow">
    
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
                        <a href="{{ route('blogs.public') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition">Blogs</a>
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

        <!-- Author Header -->
        @if($author)
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                    <a href="{{ route('blogs.public') }}" class="inline-flex items-center text-indigo-200 hover:text-white mb-8 transition group">
                        <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        All Blogs
                    </a>
                    
                    <div class="flex items-center gap-6">
                        <div class="w-24 h-24 bg-white/20 backdrop-blur rounded-full flex items-center justify-center text-4xl font-bold">
                            {{ strtoupper(substr($author->name, 0, 1)) }}
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $author->name }}</h1>
                            <p class="text-indigo-200 text-lg">
                                {{ $blogs->total() }} {{ Str::plural('blog', $blogs->total()) }} published
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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
                                
                                <!-- Date -->
                                <div class="text-sm text-gray-500 border-t border-gray-100 pt-4">
                                    <span>{{ $blog->published_at->format('M d, Y') }}</span>
                                    <span class="mx-2">·</span>
                                    <span>{{ ceil(str_word_count($blog->content) / 200) }} min read</span>
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
                    <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <h2 class="text-2xl font-semibold text-gray-700 mb-3">No blogs found</h2>
                    <p class="text-gray-500 mb-8">This author hasn't published any blogs yet.</p>
                    <a href="{{ route('blogs.public') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition">
                        Browse All Blogs
                    </a>
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
