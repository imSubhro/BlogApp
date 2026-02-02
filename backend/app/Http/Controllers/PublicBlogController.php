<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicBlogController extends Controller
{
    /**
     * Display all published blogs.
     */
    public function index(Request $request): View
    {
        $query = Blog::published()
            ->with('user')
            ->orderBy('published_at', 'desc');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $blogs = $query->paginate(12)->withQueryString();
        
        return view('blogs.public', compact('blogs'));
    }

    /**
     * Display a single published blog.
     */
    public function show(string $slug): View
    {
        $blog = Blog::where('slug', $slug)
            ->published()
            ->with('user')
            ->firstOrFail();

        // Get related blogs (same author, excluding current)
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where('user_id', $blog->user_id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // If not enough from same author, get recent blogs
        if ($relatedBlogs->count() < 3) {
            $moreBlogs = Blog::published()
                ->where('id', '!=', $blog->id)
                ->whereNotIn('id', $relatedBlogs->pluck('id'))
                ->orderBy('published_at', 'desc')
                ->take(3 - $relatedBlogs->count())
                ->get();
            
            $relatedBlogs = $relatedBlogs->merge($moreBlogs);
        }

        return view('blogs.single', compact('blog', 'relatedBlogs'));
    }

    /**
     * Display blogs by a specific author.
     */
    public function byAuthor(int $userId): View
    {
        $blogs = Blog::published()
            ->where('user_id', $userId)
            ->with('user')
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $author = $blogs->first()?->user;

        return view('blogs.by-author', compact('blogs', 'author'));
    }
}
