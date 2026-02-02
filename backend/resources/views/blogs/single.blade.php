<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Primary Meta Tags -->
    <title>{{ $blog->title }} - {{ config('app.name', 'BlogApp') }}</title>
    <meta name="title" content="{{ $blog->title }} - {{ config('app.name', 'BlogApp') }}">
    <meta name="description" content="{{ $blog->excerpt ?: $blog->shortExcerpt }}">
    <meta name="author" content="{{ $blog->user->name }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ route('blogs.single', $blog->slug) }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ route('blogs.single', $blog->slug) }}">
    <meta property="og:title" content="{{ $blog->title }}">
    <meta property="og:description" content="{{ $blog->excerpt ?: $blog->shortExcerpt }}">
    @if($blog->featured_image)
    <meta property="og:image" content="{{ asset('storage/' . $blog->featured_image) }}">
    @endif
    <meta property="article:published_time" content="{{ $blog->published_at->toIso8601String() }}">
    <meta property="article:modified_time" content="{{ $blog->updated_at->toIso8601String() }}">
    <meta property="article:author" content="{{ $blog->user->name }}">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ route('blogs.single', $blog->slug) }}">
    <meta name="twitter:title" content="{{ $blog->title }}">
    <meta name="twitter:description" content="{{ $blog->excerpt ?: $blog->shortExcerpt }}">
    @if($blog->featured_image)
    <meta name="twitter:image" content="{{ asset('storage/' . $blog->featured_image) }}">
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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

    <!-- Article -->
    <article class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Link -->
            <a href="{{ route('blogs.public') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-8 transition group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to all blogs
            </a>

            <!-- Featured Image -->
            @if($blog->featured_image)
                <div class="mb-8 rounded-2xl overflow-hidden shadow-lg">
                    <img 
                        src="{{ asset('storage/' . $blog->featured_image) }}" 
                        alt="{{ $blog->title }}" 
                        class="w-full h-auto max-h-[500px] object-cover"
                    >
                </div>
            @endif

            <!-- Header -->
            <header class="mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    {{ $blog->title }}
                </h1>
                
                <!-- Author & Meta -->
                <div class="flex flex-wrap items-center gap-4 text-gray-600">
                    <a href="{{ route('blogs.by-author', $blog->user_id) }}" class="flex items-center hover:text-indigo-600 transition">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-lg">
                            {{ strtoupper(substr($blog->user->name, 0, 1)) }}
                        </div>
                        <div class="ml-3">
                            <p class="font-semibold text-gray-900">{{ $blog->user->name }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $blog->published_at->format('M d, Y') }}
                            </p>
                        </div>
                    </a>
                    <span class="text-gray-300">|</span>
                    <span class="text-sm text-gray-500">
                        {{ ceil(str_word_count($blog->content) / 200) }} min read
                    </span>
                </div>
            </header>

            <!-- Excerpt -->
            @if($blog->excerpt)
                <div class="mb-8 p-6 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl border-l-4 border-indigo-500">
                    <p class="text-lg text-gray-700 italic leading-relaxed">{{ $blog->excerpt }}</p>
                </div>
            @endif

            <!-- Content -->
            <div class="prose prose-lg max-w-none prose-indigo 
                        prose-headings:text-gray-900 prose-headings:font-bold
                        prose-p:text-gray-700 prose-p:leading-relaxed
                        prose-a:text-indigo-600 prose-a:no-underline hover:prose-a:underline
                        prose-strong:text-gray-900
                        prose-blockquote:border-indigo-500 prose-blockquote:bg-gray-50 prose-blockquote:py-1 prose-blockquote:px-4 prose-blockquote:rounded-r-lg
                        prose-code:bg-gray-100 prose-code:px-2 prose-code:py-1 prose-code:rounded prose-code:text-indigo-600
                        prose-pre:bg-gray-900 prose-pre:text-gray-100">
                {!! nl2br(e($blog->content)) !!}
            </div>

            <!-- Share Section -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Share this article</h3>
                
                <!-- Native Share Button (for mobile) -->
                <div id="native-share" class="hidden mb-4">
                    <button onclick="shareNative()" class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                        Share via...
                    </button>
                </div>

                <!-- Social Share Buttons Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                    <!-- Twitter/X -->
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blogs.single', $blog->slug)) }}&text={{ urlencode($blog->title) }}" 
                       target="_blank"
                       rel="noopener noreferrer"
                       class="flex items-center justify-center px-4 py-3 bg-black text-white rounded-xl hover:bg-gray-800 transition shadow-md hover:shadow-lg group">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        <span class="font-medium">Twitter</span>
                    </a>

                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blogs.single', $blog->slug)) }}" 
                       target="_blank"
                       rel="noopener noreferrer"
                       class="flex items-center justify-center px-4 py-3 bg-[#1877F2] text-white rounded-xl hover:bg-[#166FE5] transition shadow-md hover:shadow-lg group">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        <span class="font-medium">Facebook</span>
                    </a>

                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('blogs.single', $blog->slug)) }}" 
                       target="_blank"
                       rel="noopener noreferrer"
                       class="flex items-center justify-center px-4 py-3 bg-[#0A66C2] text-white rounded-xl hover:bg-[#004182] transition shadow-md hover:shadow-lg group">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        <span class="font-medium">LinkedIn</span>
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' - ' . route('blogs.single', $blog->slug)) }}" 
                       target="_blank"
                       rel="noopener noreferrer"
                       class="flex items-center justify-center px-4 py-3 bg-[#25D366] text-white rounded-xl hover:bg-[#128C7E] transition shadow-md hover:shadow-lg group">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        <span class="font-medium">WhatsApp</span>
                    </a>

                    <!-- Telegram -->
                    <a href="https://t.me/share/url?url={{ urlencode(route('blogs.single', $blog->slug)) }}&text={{ urlencode($blog->title) }}" 
                       target="_blank"
                       rel="noopener noreferrer"
                       class="flex items-center justify-center px-4 py-3 bg-[#0088cc] text-white rounded-xl hover:bg-[#006699] transition shadow-md hover:shadow-lg group">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                        <span class="font-medium">Telegram</span>
                    </a>

                    <!-- Email -->
                    <a href="mailto:?subject={{ urlencode($blog->title) }}&body={{ urlencode('Check out this article: ' . route('blogs.single', $blog->slug)) }}" 
                       class="flex items-center justify-center px-4 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition shadow-md hover:shadow-lg group">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-medium">Email</span>
                    </a>
                </div>

                <!-- Copy Link Button -->
                <div class="mt-4">
                    <button id="copy-link-btn" onclick="copyLink()" class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition border-2 border-dashed border-gray-300 hover:border-indigo-400 group">
                        <svg id="copy-icon" class="w-5 h-5 mr-2 text-gray-500 group-hover:text-indigo-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <svg id="check-icon" class="w-5 h-5 mr-2 text-green-600 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span id="copy-text" class="font-medium">Copy Link to Clipboard</span>
                    </button>
                </div>
            </div>

            <script>
                // Check if native share is available (mainly for mobile)
                if (navigator.share) {
                    document.getElementById('native-share').classList.remove('hidden');
                }

                function shareNative() {
                    navigator.share({
                        title: '{{ $blog->title }}',
                        text: '{{ $blog->excerpt ?: "Check out this article!" }}',
                        url: '{{ route("blogs.single", $blog->slug) }}'
                    }).catch(console.error);
                }

                function copyLink() {
                    const url = '{{ route("blogs.single", $blog->slug) }}';
                    navigator.clipboard.writeText(url).then(() => {
                        // Show success state
                        document.getElementById('copy-icon').classList.add('hidden');
                        document.getElementById('check-icon').classList.remove('hidden');
                        document.getElementById('copy-text').textContent = 'Link Copied!';
                        document.getElementById('copy-link-btn').classList.add('bg-green-50', 'border-green-400');
                        
                        // Reset after 3 seconds
                        setTimeout(() => {
                            document.getElementById('copy-icon').classList.remove('hidden');
                            document.getElementById('check-icon').classList.add('hidden');
                            document.getElementById('copy-text').textContent = 'Copy Link to Clipboard';
                            document.getElementById('copy-link-btn').classList.remove('bg-green-50', 'border-green-400');
                        }, 3000);
                    });
                }
            </script>

            <!-- Author Bio -->
            <div class="mt-12 p-6 bg-white rounded-2xl shadow-md">
                <div class="flex items-start gap-4">
                    <a href="{{ route('blogs.by-author', $blog->user_id) }}" class="flex-shrink-0">
                        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-2xl">
                            {{ strtoupper(substr($blog->user->name, 0, 1)) }}
                        </div>
                    </a>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Written by</p>
                        <a href="{{ route('blogs.by-author', $blog->user_id) }}" class="text-xl font-bold text-gray-900 hover:text-indigo-600 transition">
                            {{ $blog->user->name }}
                        </a>
                        <p class="text-gray-600 mt-2">
                            Published on {{ $blog->published_at->format('F d, Y') }}
                        </p>
                        <a href="{{ route('blogs.by-author', $blog->user_id) }}" class="inline-flex items-center mt-3 text-indigo-600 hover:text-indigo-800 font-medium transition">
                            View all posts by this author
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </article>

    <!-- Related Blogs -->
    @if(isset($relatedBlogs) && $relatedBlogs->count() > 0)
        <section class="bg-white py-16 border-t">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">More Blogs You Might Like</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($relatedBlogs as $related)
                        <article class="bg-gray-50 rounded-xl overflow-hidden hover:shadow-lg transition group">
                            <a href="{{ route('blogs.single', $related->slug) }}" class="block">
                                @if($related->featured_image)
                                    <img 
                                        src="{{ asset('storage/' . $related->featured_image) }}" 
                                        alt="{{ $related->title }}" 
                                        class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="h-40 bg-gradient-to-br from-indigo-500 to-purple-600"></div>
                                @endif
                            </a>
                            <div class="p-5">
                                <a href="{{ route('blogs.single', $related->slug) }}">
                                    <h3 class="font-bold text-gray-900 group-hover:text-indigo-600 transition line-clamp-2 mb-2">
                                        {{ $related->title }}
                                    </h3>
                                </a>
                                <p class="text-sm text-gray-500">
                                    {{ $related->published_at->format('M d, Y') }} · {{ $related->user->name }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 text-white mb-6">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span class="text-xl font-bold">BlogApp</span>
            </a>
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'BlogApp') }}. Built with Laravel & Tailwind CSS.</p>
        </div>
    </footer>
</body>
</html>
