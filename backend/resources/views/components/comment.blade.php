@props(['comment', 'blog', 'depth' => 0])

@php
    $maxDepth = 3; // Maximum nesting level for replies
    $canReply = auth()->check() && $depth < $maxDepth;
@endphp

<div id="comment-{{ $comment->id }}" class="group {{ $depth > 0 ? 'ml-8 border-l-2 border-gray-200 pl-4' : '' }}">
    <div class="bg-white rounded-lg p-4 {{ $depth > 0 ? 'bg-gray-50' : 'shadow-sm border border-gray-100' }} transition-all hover:shadow-md">
        <!-- Comment Header -->
        <div class="flex items-start justify-between mb-3">
            <div class="flex items-center space-x-3">
                <!-- Avatar -->
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                </div>
                <div>
                    <a href="{{ route('blogs.by-author', $comment->user->id) }}" class="font-semibold text-gray-900 hover:text-indigo-600 transition-colors">
                        {{ $comment->user->name }}
                    </a>
                    @if($comment->user->id === $blog->user_id)
                        <span class="ml-2 px-2 py-0.5 text-xs font-medium bg-indigo-100 text-indigo-700 rounded-full">Author</span>
                    @endif
                    <p class="text-sm text-gray-500">{{ $comment->formatted_date }}</p>
                </div>
            </div>
            
            <!-- Actions Dropdown -->
            @auth
                @if(auth()->id() === $comment->user_id || auth()->id() === $blog->user_id)
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="p-1 rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors opacity-0 group-hover:opacity-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition 
                             class="absolute right-0 mt-2 w-36 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-10">
                            @if(auth()->id() === $comment->user_id)
                                <button @click="$dispatch('edit-comment', { id: {{ $comment->id }}, content: `{{ addslashes($comment->content) }}` }); open = false" 
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </button>
                            @endif
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
        
        <!-- Comment Content -->
        <div class="text-gray-700 leading-relaxed mb-3 comment-content" id="comment-content-{{ $comment->id }}">
            {!! nl2br(e($comment->content)) !!}
        </div>
        
        <!-- Edit Form (Hidden by default) -->
        <div x-data="{ editing: false }" 
             x-on:edit-comment.window="if ($event.detail.id === {{ $comment->id }}) { editing = true; }"
             x-show="editing" 
             x-cloak
             class="mb-3">
            <form action="{{ route('comments.update', $comment) }}" method="POST">
                @csrf
                @method('PUT')
                <textarea name="content" rows="3" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none"
                          required>{{ $comment->content }}</textarea>
                <div class="flex justify-end space-x-2 mt-2">
                    <button type="button" @click="editing = false" 
                            class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Reply Button -->
        @if($canReply)
            <div x-data="{ showReplyForm: false }">
                <button @click="showReplyForm = !showReplyForm" 
                        class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                    </svg>
                    Reply
                </button>
                
                <!-- Reply Form -->
                <div x-show="showReplyForm" x-transition class="mt-3">
                    <form action="{{ route('comments.store', $blog) }}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <textarea name="content" rows="2" 
                                  placeholder="Write a reply..." 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none text-sm"
                                  required></textarea>
                        <div class="flex justify-end space-x-2 mt-2">
                            <button type="button" @click="showReplyForm = false" 
                                    class="px-3 py-1.5 text-sm text-gray-600 hover:text-gray-800 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-3 py-1.5 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                Post Reply
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Nested Replies -->
    @if($comment->replies && $comment->replies->count() > 0)
        <div class="mt-3 space-y-3">
            @foreach($comment->replies as $reply)
                <x-comment :comment="$reply" :blog="$blog" :depth="$depth + 1" />
            @endforeach
        </div>
    @endif
</div>
