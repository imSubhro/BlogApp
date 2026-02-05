@props(['blog', 'comments'])

<section id="comments" class="mt-12">
    <!-- Section Header -->
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-bold text-gray-900 flex items-center">
            <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            Comments
            <span class="ml-2 px-3 py-1 text-sm font-semibold bg-indigo-100 text-indigo-700 rounded-full">
                {{ $comments->count() }}
            </span>
        </h2>
    </div>
    
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <!-- New Comment Form -->
    @auth
        <div class="mb-8 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start space-x-4">
                <!-- User Avatar -->
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-md flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                
                <!-- Comment Form -->
                <form action="{{ route('comments.store', $blog) }}" method="POST" class="flex-1">
                    @csrf
                    <textarea name="content" rows="3" 
                              placeholder="Share your thoughts..." 
                              class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none transition-all placeholder-gray-400"
                              required></textarea>
                    <div class="flex justify-end mt-3">
                        <button type="submit" 
                                class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Post Comment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="mb-8 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-6 text-center border border-indigo-100">
            <svg class="w-12 h-12 mx-auto text-indigo-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
            <p class="text-gray-700 mb-4">Join the conversation! Log in to share your thoughts.</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('login') }}" 
                   class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                    Log In
                </a>
                <a href="{{ route('register') }}" 
                   class="px-6 py-2.5 border border-indigo-600 text-indigo-600 font-semibold rounded-lg hover:bg-indigo-50 transition-colors">
                    Sign Up
                </a>
            </div>
        </div>
    @endauth
    
    <!-- Comments List -->
    @if($comments->count() > 0)
        <div class="space-y-4">
            @foreach($comments as $comment)
                <x-comment :comment="$comment" :blog="$blog" />
            @endforeach
        </div>
    @else
        <div class="text-center py-12 bg-gray-50 rounded-xl">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">No comments yet</h3>
            <p class="text-gray-500">Be the first to share your thoughts!</p>
        </div>
    @endif
</section>
