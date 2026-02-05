<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Hero Welcome Section -->
        <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500">
            <!-- Pattern Overlay -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <!-- Success Message -->
                @if (session('success'))
                    <div class="mb-6 bg-white/10 backdrop-blur-md border border-white/20 text-white px-6 py-4 rounded-xl flex items-center" role="alert">
                        <svg class="w-5 h-5 mr-3 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <!-- Welcome Text -->
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 md:w-20 md:h-20 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-3xl md:text-4xl font-bold text-white shadow-lg ring-2 ring-white/30">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-white/70 text-sm font-medium">Welcome back,</p>
                            <h1 class="text-2xl md:text-3xl font-bold text-white tracking-tight">
                                {{ Auth::user()->name }} 👋
                            </h1>
                            <p class="text-white/70 text-sm mt-1">
                                {{ now()->format('l, F j, Y') }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Quick Create Button -->
                    <a href="{{ route('blogs.create') }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 font-semibold rounded-xl hover:bg-indigo-50 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 group">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create New Blog
                    </a>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-8">
                    <!-- Total Blogs -->
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20 hover:bg-white/15 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white/70 text-sm font-medium">Total Blogs</p>
                                <p class="text-3xl font-bold text-white mt-1">{{ $totalBlogs }}</p>
                            </div>
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center text-xs text-white/60">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            All your articles
                        </div>
                    </div>

                    <!-- Published -->
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20 hover:bg-white/15 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white/70 text-sm font-medium">Published</p>
                                <p class="text-3xl font-bold text-white mt-1">{{ $publishedBlogs }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-400/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center text-xs text-green-300/80">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Live & visible
                        </div>
                    </div>

                    <!-- Drafts -->
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20 hover:bg-white/15 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white/70 text-sm font-medium">Drafts</p>
                                <p class="text-3xl font-bold text-white mt-1">{{ $draftBlogs }}</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-400/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center text-xs text-yellow-300/80">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Work in progress
                        </div>
                    </div>

                    <!-- Publish Rate -->
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20 hover:bg-white/15 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white/70 text-sm font-medium">Publish Rate</p>
                                <p class="text-3xl font-bold text-white mt-1">
                                    {{ $totalBlogs > 0 ? round(($publishedBlogs / $totalBlogs) * 100) : 0 }}%
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-purple-400/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="w-full bg-white/20 rounded-full h-1.5">
                                <div class="bg-purple-300 h-1.5 rounded-full transition-all duration-500" style="width: {{ $totalBlogs > 0 ? ($publishedBlogs / $totalBlogs) * 100 : 0 }}%"></div>
                            </div>
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

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Quick Actions Panel -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Quick Actions Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Quick Actions
                            </h3>
                        </div>
                        <div class="p-4 space-y-2">
                            <a href="{{ route('blogs.create') }}" class="flex items-center p-4 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-xl hover:from-indigo-600 hover:to-purple-600 transition group shadow-sm">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold">Create New Blog</p>
                                    <p class="text-xs text-white/70">Start writing your next article</p>
                                </div>
                            </a>
                            
                            <a href="{{ route('blogs.index') }}" class="flex items-center p-4 bg-gray-50 text-gray-700 rounded-xl hover:bg-gray-100 transition group">
                                <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center mr-4 group-hover:bg-indigo-100 group-hover:text-indigo-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Manage Blogs</p>
                                    <p class="text-xs text-gray-500">View and edit all your posts</p>
                                </div>
                            </a>
                            
                            <a href="{{ route('blogs.public') }}" class="flex items-center p-4 bg-gray-50 text-gray-700 rounded-xl hover:bg-gray-100 transition group">
                                <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-100 group-hover:text-green-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Browse Public Blogs</p>
                                    <p class="text-xs text-gray-500">Discover community content</p>
                                </div>
                            </a>
                            
                            <a href="{{ route('profile.edit') }}" class="flex items-center p-4 bg-gray-50 text-gray-700 rounded-xl hover:bg-gray-100 transition group">
                                <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center mr-4 group-hover:bg-purple-100 group-hover:text-purple-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Edit Profile</p>
                                    <p class="text-xs text-gray-500">Update your account settings</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Writing Tips Card -->
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl border border-amber-200/50 p-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-amber-900 mb-1">Writing Tip</h4>
                                <p class="text-sm text-amber-700">Great headlines grab attention! Try using numbers, questions, or power words in your blog titles.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Blogs Panel -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                            <h3 class="font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Recent Activity
                            </h3>
                            @if($recentBlogs->count() > 0)
                                <a href="{{ route('blogs.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium flex items-center group">
                                    View All
                                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                        
                        <div class="p-4">
                            @if($recentBlogs->count() > 0)
                                <div class="space-y-3">
                                    @foreach($recentBlogs as $blog)
                                        <div class="group flex items-center gap-4 p-4 bg-gray-50 rounded-xl hover:bg-indigo-50 transition border border-transparent hover:border-indigo-100">
                                            <!-- Blog Thumbnail -->
                                            <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden bg-gradient-to-br from-indigo-500 to-purple-500">
                                                @if($blog->featured_image)
                                                    <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <!-- Blog Info -->
                                            <div class="flex-1 min-w-0">
                                                <a href="{{ route('blogs.edit', $blog) }}" class="font-semibold text-gray-900 group-hover:text-indigo-600 transition truncate block">
                                                    {{ $blog->title }}
                                                </a>
                                                <div class="flex items-center gap-3 mt-1 text-sm">
                                                    <span class="text-gray-500">
                                                        Updated {{ $blog->updated_at->diffForHumans() }}
                                                    </span>
                                                    @if($blog->category)
                                                        <span class="px-2 py-0.5 rounded-full text-xs" style="background-color: {{ $blog->category->color }}20; color: {{ $blog->category->color }};">
                                                            {{ $blog->category->name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Status & Actions -->
                                            <div class="flex items-center gap-3">
                                                @if($blog->isPublished())
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
                                                        Live
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5"></span>
                                                        Draft
                                                    </span>
                                                @endif
                                                
                                                <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
                                                    <a href="{{ route('blogs.edit', $blog) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-100 rounded-lg transition" title="Edit">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </a>
                                                    @if($blog->isPublished())
                                                        <a href="{{ route('blogs.single', $blog->slug) }}" class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-100 rounded-lg transition" title="View" target="_blank">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <!-- Empty State -->
                                <div class="text-center py-12">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-800 mb-2">No blogs yet</h4>
                                    <p class="text-gray-500 mb-6 max-w-sm mx-auto">Start your writing journey by creating your first blog post. Share your ideas with the world!</p>
                                    <a href="{{ route('blogs.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition shadow-lg">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Create Your First Blog
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
