<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicBlogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    $recentBlogs = \App\Models\Blog::published()
        ->with('user')
        ->orderBy('published_at', 'desc')
        ->take(6)
        ->get();
    
    return view('welcome', compact('recentBlogs'));
})->name('home');

// Public blog routes
Route::get('/blogs', [PublicBlogController::class, 'index'])->name('blogs.public');
Route::get('/blogs/{slug}', [PublicBlogController::class, 'show'])->name('blogs.single');
Route::get('/author/{userId}', [PublicBlogController::class, 'byAuthor'])->name('blogs.by-author');

// Dashboard with stats
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    $totalBlogs = $user->totalBlogsCount();
    $publishedBlogs = $user->publishedBlogsCount();
    $draftBlogs = $user->draftBlogsCount();
    
    // Get recent blogs for dashboard
    $recentBlogs = $user->blogs()
        ->orderBy('updated_at', 'desc')
        ->take(5)
        ->get();
    
    return view('dashboard', compact('totalBlogs', 'publishedBlogs', 'draftBlogs', 'recentBlogs'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Blog CRUD routes
    Route::get('/my-blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('/my-blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/my-blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('/my-blogs/{blog}', [BlogController::class, 'show'])->name('blogs.show');
    Route::get('/my-blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/my-blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/my-blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
    
    // Additional blog actions
    Route::patch('/my-blogs/{blog}/toggle-status', [BlogController::class, 'toggleStatus'])->name('blogs.toggle-status');
    Route::delete('/my-blogs/{blog}/remove-image', [BlogController::class, 'removeImage'])->name('blogs.remove-image');
});

require __DIR__.'/auth.php';
