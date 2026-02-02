<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('blogs.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Preview Blog') }}
                </h2>
            </div>
            <div class="flex items-center gap-3">
                @if($blog->isPublished())
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        Published
                    </span>
                    <a href="{{ route('blogs.single', $blog->slug) }}" target="_blank" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        View Public
                    </a>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        Draft
                    </span>
                @endif
                <a href="{{ route('blogs.edit', $blog) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <article class="p-8">
                    <!-- Featured Image -->
                    @if($blog->featured_image)
                        <div class="mb-8 rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-auto max-h-[400px] object-cover">
                        </div>
                    @endif

                    <!-- Title -->
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        {{ $blog->title }}
                    </h1>

                    <!-- Meta -->
                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-8 pb-6 border-b">
                        <span>Created {{ $blog->created_at->format('M d, Y') }}</span>
                        <span>•</span>
                        <span>{{ ceil(str_word_count($blog->content) / 200) }} min read</span>
                        @if($blog->isPublished())
                            <span>•</span>
                            <span class="text-green-600">Published {{ $blog->published_at->format('M d, Y') }}</span>
                        @endif
                    </div>

                    <!-- Excerpt -->
                    @if($blog->excerpt)
                        <div class="mb-8 p-4 bg-gray-50 rounded-lg border-l-4 border-indigo-500">
                            <p class="text-gray-700 italic">{{ $blog->excerpt }}</p>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="prose prose-lg max-w-none prose-indigo">
                        {!! nl2br(e($blog->content)) !!}
                    </div>
                </article>
            </div>

            <!-- Blog Info Card -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Blog Information</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500">Slug</dt>
                        <dd class="text-gray-900 font-mono">{{ $blog->slug }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Status</dt>
                        <dd>
                            @if($blog->isPublished())
                                <span class="text-green-600 font-medium">Published</span>
                            @else
                                <span class="text-yellow-600 font-medium">Draft</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Created</dt>
                        <dd class="text-gray-900">{{ $blog->created_at->format('M d, Y \a\t h:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Last Updated</dt>
                        <dd class="text-gray-900">{{ $blog->updated_at->format('M d, Y \a\t h:i A') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
