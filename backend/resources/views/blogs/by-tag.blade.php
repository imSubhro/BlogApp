<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>#{{ $tag->name }} - {{ config('app.name', 'BlogApp') }}</title>
    <meta name="description" content="Browse all blogs tagged with #{{ $tag->name }}">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
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
                    <a href="{{ route('blogs.public') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition">All Blogs</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition">Log in</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <header class="text-center mb-12">
            <div class="inline-flex items-center px-6 py-3 rounded-full text-xl font-bold mb-4" style="background-color: {{ $tag->color }}20; color: {{ $tag->color }};">
                #{{ $tag->name }}
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Blogs tagged with "{{ $tag->name }}"</h1>
            <p class="text-gray-500">{{ $blogs->total() }} {{ Str::plural('article', $blogs->total()) }}</p>
        </header>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="flex-1">
                @if($blogs->count() > 0)
                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach($blogs as $blog)
                            <article class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all overflow-hidden group">
                                <a href="{{ route('blogs.single', $blog->slug) }}" class="block">
                                    @if($blog->featured_image)
                                        <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                    @else
                                        <div class="h-48 bg-gradient-to-br from-indigo-500 to-purple-600"></div>
                                    @endif
                                </a>
                                <div class="p-6">
                                    @if($blog->category)
                                        <a href="{{ route('blogs.by-category', $blog->category->slug) }}" class="inline-block px-2 py-1 text-xs font-medium rounded-full mb-2" style="background-color: {{ $blog->category->color }}20; color: {{ $blog->category->color }};">
                                            {{ $blog->category->name }}
                                        </a>
                                    @endif
                                    <a href="{{ route('blogs.single', $blog->slug) }}">
                                        <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition line-clamp-2">{{ $blog->title }}</h2>
                                    </a>
                                    <p class="text-gray-600 mb-4 line-clamp-2">{{ $blog->shortExcerpt }}</p>
                                    <div class="flex items-center justify-between">
                                        <a href="{{ route('blogs.by-author', $blog->user_id) }}" class="flex items-center hover:text-indigo-600 transition">
                                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-sm">
                                                {{ strtoupper(substr($blog->user->name, 0, 1)) }}
                                            </div>
                                            <span class="ml-2 text-sm text-gray-700">{{ $blog->user->name }}</span>
                                        </a>
                                        <span class="text-sm text-gray-500">{{ $blog->published_at->format('M d, Y') }}</span>
                                    </div>
                                    @if($blog->tags->count() > 0)
                                        <div class="flex flex-wrap gap-1 mt-3">
                                            @foreach($blog->tags->take(3) as $blogTag)
                                                <a href="{{ route('blogs.by-tag', $blogTag->slug) }}" 
                                                   class="px-2 py-1 text-xs rounded-full hover:opacity-80 transition {{ $blogTag->id === $tag->id ? 'font-semibold' : '' }}" 
                                                   style="background-color: {{ $blogTag->color }}20; color: {{ $blogTag->color }};">
                                                    {{ $blogTag->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                    
                    <div class="mt-8">
                        {{ $blogs->links() }}
                    </div>
                @else
                    <div class="text-center py-16 bg-white rounded-xl">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-600">No blogs with this tag yet</h3>
                        <p class="text-gray-500 mt-2">Check back later for new content!</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <aside class="w-full lg:w-72 space-y-6">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Popular Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($popularTags as $popularTag)
                            <a href="{{ route('blogs.by-tag', $popularTag->slug) }}" 
                               class="px-3 py-1.5 text-sm rounded-full transition {{ $popularTag->id === $tag->id ? 'ring-2 ring-offset-1' : 'hover:opacity-80' }}" 
                               style="background-color: {{ $popularTag->color }}20; color: {{ $popularTag->color }}; {{ $popularTag->id === $tag->id ? 'ring-color: ' . $popularTag->color : '' }}">
                                #{{ $popularTag->name }}
                                <span class="text-xs opacity-70">({{ $popularTag->blogs_count }})</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 text-white mb-6">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span class="text-xl font-bold">BlogApp</span>
            </a>
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'BlogApp') }}. Built with love by imSubhro</p>
        </div>
    </footer>
</body>
</html>
