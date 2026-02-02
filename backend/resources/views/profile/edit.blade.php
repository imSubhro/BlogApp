<x-app-layout>
    <!-- Hero Header -->
    <div class="relative bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-purple-300/20 rounded-full blur-3xl"></div>
        </div>
        
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col sm:flex-row items-center gap-6">
                <!-- Avatar -->
                <div class="relative">
                    <div class="w-24 h-24 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center text-white text-4xl font-bold shadow-2xl border-4 border-white/30">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
                
                <!-- User Info -->
                <div class="text-center sm:text-left flex-1">
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-1">{{ Auth::user()->name }}</h1>
                    <p class="text-white/80 mb-3">{{ Auth::user()->email }}</p>
                    <span class="inline-flex items-center px-3 py-1 bg-white/20 backdrop-blur-lg rounded-full text-white text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Member since {{ Auth::user()->created_at->format('M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <!-- Update Profile Button -->
            <button onclick="toggleSection('profile-section')" 
                    class="flex items-center p-4 bg-white rounded-xl shadow-md hover:shadow-lg transition-all group border-2 border-transparent hover:border-indigo-500">
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mr-4 group-hover:bg-indigo-200 transition">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="text-left">
                    <p class="font-semibold text-gray-900">Update Profile</p>
                    <p class="text-sm text-gray-500">Edit name & email</p>
                </div>
            </button>

            <!-- Update Password Button -->
            <button onclick="toggleSection('password-section')" 
                    class="flex items-center p-4 bg-white rounded-xl shadow-md hover:shadow-lg transition-all group border-2 border-transparent hover:border-emerald-500">
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center mr-4 group-hover:bg-emerald-200 transition">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div class="text-left">
                    <p class="font-semibold text-gray-900">Update Password</p>
                    <p class="text-sm text-gray-500">Change or reset</p>
                </div>
            </button>

            <!-- Delete Account Button -->
            <button onclick="toggleSection('delete-section')" 
                    class="flex items-center p-4 bg-white rounded-xl shadow-md hover:shadow-lg transition-all group border-2 border-transparent hover:border-red-500">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mr-4 group-hover:bg-red-200 transition">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div class="text-left">
                    <p class="font-semibold text-gray-900">Delete Account</p>
                    <p class="text-sm text-gray-500">Remove account</p>
                </div>
            </button>
        </div>

        <!-- Profile Section (Hidden by default) -->
        <div id="profile-section" class="hidden mb-6">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Profile Information
                    </h3>
                    <button onclick="toggleSection('profile-section')" class="text-white/80 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <!-- Password Section (Hidden by default) -->
        <div id="password-section" class="hidden mb-6">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Update Password
                    </h3>
                    <button onclick="toggleSection('password-section')" class="text-white/80 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <!-- Delete Section (Hidden by default) -->
        <div id="delete-section" class="hidden mb-6">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-red-100">
                <div class="px-6 py-4 bg-gradient-to-r from-red-600 to-rose-600 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        Danger Zone
                    </h3>
                    <button onclick="toggleSection('delete-section')" class="text-white/80 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSection(sectionId) {
            const section = document.getElementById(sectionId);
            const allSections = ['profile-section', 'password-section', 'delete-section'];
            
            // Close all other sections
            allSections.forEach(id => {
                if (id !== sectionId) {
                    document.getElementById(id).classList.add('hidden');
                }
            });
            
            // Toggle current section
            section.classList.toggle('hidden');
            
            // Scroll to section if opened
            if (!section.classList.contains('hidden')) {
                section.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    </script>
</x-app-layout>
