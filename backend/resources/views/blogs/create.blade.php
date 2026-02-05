<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Page Header -->
        <div class="bg-white border-b">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('blogs.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Create New Blog</h1>
                        <p class="text-gray-500 mt-1">Share your thoughts with the world</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                value="{{ old('title') }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('title') border-red-500 @enderror"
                                placeholder="Enter your blog title..."
                                required
                            >
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Excerpt -->
                        <div>
                            <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                                Excerpt
                                <span class="text-gray-400 font-normal">(optional)</span>
                            </label>
                            <textarea 
                                name="excerpt" 
                                id="excerpt" 
                                rows="2"
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('excerpt') border-red-500 @enderror"
                                placeholder="A brief summary of your blog..."
                            >{{ old('excerpt') }}</textarea>
                            <p class="mt-1 text-xs text-gray-400">Leave empty to auto-generate. Max 500 characters.</p>
                            @error('excerpt')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Content -->
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                Content <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                name="content" 
                                id="content" 
                                rows="12"
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition font-mono text-sm @error('content') border-red-500 @enderror"
                                placeholder="Write your blog content here..."
                                required
                            >{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Divider -->
                    <div class="border-t border-gray-100"></div>
                    
                    <!-- Media & Meta Section -->
                    <div class="p-6 bg-gray-50/50 space-y-6">
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Media & Details</h3>
                        
                        <!-- Featured Image -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
                            <div class="flex items-center gap-4">
                                <div id="image-preview" class="hidden w-24 h-24 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                    <img id="preview-img" src="" alt="Preview" class="w-full h-full object-cover">
                                </div>
                                <label for="featured_image" class="flex-1 flex items-center justify-center px-6 py-4 border-2 border-gray-200 border-dashed rounded-lg cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/50 transition">
                                    <div class="text-center">
                                        <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <p class="mt-1 text-sm text-gray-500">
                                            <span class="text-indigo-600 font-medium">Upload</span> or drag and drop
                                        </p>
                                        <p class="text-xs text-gray-400">PNG, JPG, WEBP up to 2MB</p>
                                    </div>
                                    <input id="featured_image" name="featured_image" type="file" class="sr-only" accept="image/*">
                                </label>
                            </div>
                            @error('featured_image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Category & Tags Grid -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select 
                                    name="category_id" 
                                    id="category_id" 
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white"
                                >
                                    <option value="">Select category...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <div class="flex gap-3">
                                    <label class="flex-1 flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-indigo-400 transition has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                        <input type="radio" name="status" value="draft" class="h-4 w-4 text-indigo-600" {{ old('status', 'draft') === 'draft' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm font-medium text-gray-700">Draft</span>
                                    </label>
                                    <label class="flex-1 flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-green-400 transition has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                        <input type="radio" name="status" value="published" class="h-4 w-4 text-green-600" {{ old('status') === 'published' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm font-medium text-gray-700">Publish</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tags -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                            <div id="selected-tags" class="flex flex-wrap gap-2 p-3 bg-white border border-gray-200 rounded-lg min-h-[48px]">
                                <span class="text-sm text-gray-400" id="tags-placeholder">Click tags below or add new ones...</span>
                            </div>
                            <div class="mt-3 flex gap-2">
                                <input 
                                    type="text" 
                                    id="tag-input" 
                                    class="flex-1 px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                    placeholder="Add new tag..."
                                >
                                <button type="button" id="add-tag-btn" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                                    Add
                                </button>
                            </div>
                            <div id="tag-suggestions" class="mt-3">
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($tags as $tag)
                                        <button type="button" 
                                                class="tag-suggestion px-3 py-1 text-xs rounded-full border transition hover:shadow-sm"
                                                data-id="{{ $tag->id }}"
                                                data-name="{{ $tag->name }}"
                                                style="border-color: {{ $tag->color }}; color: {{ $tag->color }};"
                                        >
                                            {{ $tag->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                        <a href="{{ route('blogs.index') }}" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 font-medium rounded-lg hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-sm">
                            Create Blog
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Image Preview
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

        // Tags functionality
        const selectedTags = new Map();
        const selectedTagsContainer = document.getElementById('selected-tags');
        const tagsPlaceholder = document.getElementById('tags-placeholder');
        const tagInput = document.getElementById('tag-input');
        const addTagBtn = document.getElementById('add-tag-btn');

        function updatePlaceholder() {
            tagsPlaceholder.style.display = selectedTags.size > 0 ? 'none' : 'inline';
        }

        document.querySelectorAll('.tag-suggestion').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const name = btn.dataset.name;
                if (!selectedTags.has(id)) {
                    addTag(id, name, btn.style.color);
                    btn.classList.add('opacity-50');
                }
            });
        });

        addTagBtn.addEventListener('click', () => {
            const name = tagInput.value.trim();
            if (name) {
                const existingBtn = Array.from(document.querySelectorAll('.tag-suggestion')).find(
                    btn => btn.dataset.name.toLowerCase() === name.toLowerCase()
                );
                
                if (existingBtn && !selectedTags.has(existingBtn.dataset.id)) {
                    addTag(existingBtn.dataset.id, existingBtn.dataset.name, existingBtn.style.color);
                    existingBtn.classList.add('opacity-50');
                } else if (!existingBtn) {
                    const tempId = 'new_' + Date.now();
                    addTag(tempId, name, '#6366f1', true);
                }
                tagInput.value = '';
            }
        });

        tagInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                addTagBtn.click();
            }
        });

        function addTag(id, name, color, isNew = false) {
            selectedTags.set(id, { name, isNew });
            updatePlaceholder();
            
            const tagEl = document.createElement('span');
            tagEl.className = 'inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium';
            tagEl.style.backgroundColor = color + '20';
            tagEl.style.color = color;
            tagEl.innerHTML = `
                ${name}
                <input type="hidden" name="tags[]" value="${isNew ? name : id}">
                <button type="button" class="ml-1.5 hover:opacity-70" onclick="removeTag('${id}', this)">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            selectedTagsContainer.appendChild(tagEl);
        }

        function removeTag(id, btnEl) {
            selectedTags.delete(id);
            btnEl.closest('span').remove();
            updatePlaceholder();
            
            const suggestionBtn = document.querySelector(`.tag-suggestion[data-id="${id}"]`);
            if (suggestionBtn) {
                suggestionBtn.classList.remove('opacity-50');
            }
        }
    </script>
</x-app-layout>
