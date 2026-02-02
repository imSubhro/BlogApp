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
                    {{ __('Edit Blog') }}
                </h2>
            </div>
            @if($blog->isPublished())
                <a href="{{ route('blogs.single', $blog->slug) }}" target="_blank" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    View Published
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                value="{{ old('title', $blog->title) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('title') border-red-500 @enderror"
                                placeholder="Enter your blog title..."
                                required
                            >
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                Slug: <code class="bg-gray-100 px-2 py-1 rounded">{{ $blog->slug }}</code>
                            </p>
                        </div>
                        
                        <!-- Excerpt -->
                        <div class="mb-6">
                            <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                                Excerpt (Summary)
                            </label>
                            <textarea 
                                name="excerpt" 
                                id="excerpt" 
                                rows="2"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('excerpt') border-red-500 @enderror"
                                placeholder="A brief summary of your blog (optional)..."
                            >{{ old('excerpt', $blog->excerpt) }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Leave empty to auto-generate from content. Max 500 characters.</p>
                            @error('excerpt')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Content -->
                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                Content <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                name="content" 
                                id="content" 
                                rows="15"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition font-mono @error('content') border-red-500 @enderror"
                                placeholder="Write your blog content here..."
                                required
                            >{{ old('content', $blog->content) }}</textarea>
                            @error('content')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Current Featured Image -->
                        @if($blog->featured_image)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Current Featured Image
                                </label>
                                <div class="relative inline-block">
                                    <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="Featured Image" class="max-h-48 rounded-lg">
                                    <button type="button" 
                                            onclick="if(confirm('Remove this image?')) { document.getElementById('remove-image-form').submit(); }"
                                            class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Click the X button to remove the current image.</p>
                            </div>
                        @endif
                        
                        <!-- New Featured Image -->
                        <div class="mb-6">
                            <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $blog->featured_image ? 'Replace Featured Image' : 'Featured Image' }}
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="featured_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                            <span>Upload a file</span>
                                            <input id="featured_image" name="featured_image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF, WEBP up to 2MB</p>
                                </div>
                            </div>
                            <div id="image-preview" class="mt-3 hidden">
                                <img id="preview-img" src="" alt="Preview" class="max-h-48 rounded-lg mx-auto">
                            </div>
                            @error('featured_image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Status -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4">
                                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-indigo-400 transition has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                    <input 
                                        type="radio" 
                                        name="status" 
                                        value="draft" 
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                        {{ old('status', $blog->status) === 'draft' ? 'checked' : '' }}
                                    >
                                    <div class="ml-3">
                                        <span class="block text-sm font-medium text-gray-900">Save as Draft</span>
                                        <span class="block text-sm text-gray-500">Only you can see this</span>
                                    </div>
                                </label>
                                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-indigo-400 transition has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                    <input 
                                        type="radio" 
                                        name="status" 
                                        value="published" 
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                        {{ old('status', $blog->status) === 'published' ? 'checked' : '' }}
                                    >
                                    <div class="ml-3">
                                        <span class="block text-sm font-medium text-gray-900">Publish</span>
                                        <span class="block text-sm text-gray-500">Everyone can see this</span>
                                    </div>
                                </label>
                            </div>
                            @if($blog->isPublished())
                                <p class="mt-2 text-sm text-green-600">
                                    Published on {{ $blog->published_at->format('M d, Y \a\t h:i A') }}
                                </p>
                            @endif
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('blogs.index') }}" class="px-6 py-3 text-gray-700 bg-gray-100 font-medium rounded-lg hover:bg-gray-200 transition">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                                Update Blog
                            </button>
                        </div>
                    </form>
                    
                    <!-- Delete Form (outside main form) -->
                    <div class="pt-6 border-t border-gray-200 mt-6">
                        <form action="{{ route('blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 text-red-600 hover:text-red-800 font-medium transition flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete This Blog
                            </button>
                        </form>
                    </div>
                    
                    <!-- Hidden Remove Image Form (outside main form) -->
                    @if($blog->featured_image)
                        <form id="remove-image-form" action="{{ route('blogs.remove-image', $blog) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
            </div>
            
            <!-- Blog Meta Info -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Blog Information</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="text-gray-500">Created</dt>
                            <dd class="text-gray-900 font-medium">{{ $blog->created_at->format('M d, Y \a\t h:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Last Updated</dt>
                            <dd class="text-gray-900 font-medium">{{ $blog->updated_at->format('M d, Y \a\t h:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Status</dt>
                            <dd>
                                @if($blog->isPublished())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Published</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Draft</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Slug</dt>
                            <dd class="text-gray-900 font-medium font-mono text-xs">{{ $blog->slug }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Image Preview Script -->
    <script>
        document.getElementById('featured_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
