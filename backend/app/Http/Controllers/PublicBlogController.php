<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
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
            ->with(['user', 'category', 'tags'])
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

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by tag
        if ($request->has('tag') && $request->tag) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        $blogs = $query->paginate(12)->withQueryString();
        
        // Get categories and popular tags for sidebar
        $categories = Category::withCount(['blogs' => function ($q) {
            $q->published();
        }])->orderBy('sort_order')->get();
        
        $popularTags = Tag::popular(15)->get();
        
        return view('blogs.public', compact('blogs', 'categories', 'popularTags'));
    }

    /**
     * Display a single published blog.
     */
    public function show(string $slug): View
    {
        $blog = Blog::where('slug', $slug)
            ->published()
            ->with(['user', 'category', 'tags'])
            ->firstOrFail();

        // Get related blogs (same category or tags, excluding current)
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where(function ($q) use ($blog) {
                if ($blog->category_id) {
                    $q->where('category_id', $blog->category_id);
                }
                if ($blog->tags->count() > 0) {
                    $q->orWhereHas('tags', function ($tq) use ($blog) {
                        $tq->whereIn('tags.id', $blog->tags->pluck('id'));
                    });
                }
            })
            ->with(['user', 'category'])
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // If not enough related, get recent blogs
        if ($relatedBlogs->count() < 3) {
            $moreBlogs = Blog::published()
                ->where('id', '!=', $blog->id)
                ->whereNotIn('id', $relatedBlogs->pluck('id'))
                ->with(['user', 'category'])
                ->orderBy('published_at', 'desc')
                ->take(3 - $relatedBlogs->count())
                ->get();
            
            $relatedBlogs = $relatedBlogs->merge($moreBlogs);
        }

        // Get top-level approved comments with their replies
        $comments = $blog->topLevelComments()->get();

        return view('blogs.single', compact('blog', 'relatedBlogs', 'comments'));
    }

    /**
     * Display blogs by a specific author.
     */
    public function byAuthor(int $userId): View
    {
        $blogs = Blog::published()
            ->where('user_id', $userId)
            ->with(['user', 'category', 'tags'])
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $author = $blogs->first()?->user;

        return view('blogs.by-author', compact('blogs', 'author'));
    }

    /**
     * Display blogs by a specific category.
     */
    public function byCategory(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $blogs = Blog::published()
            ->where('category_id', $category->id)
            ->with(['user', 'category', 'tags'])
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $categories = Category::withCount(['blogs' => function ($q) {
            $q->published();
        }])->orderBy('sort_order')->get();

        return view('blogs.by-category', compact('blogs', 'category', 'categories'));
    }

    /**
     * Display blogs by a specific tag.
     */
    public function byTag(string $slug): View
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        
        $blogs = Blog::published()
            ->whereHas('tags', function ($q) use ($tag) {
                $q->where('tags.id', $tag->id);
            })
            ->with(['user', 'category', 'tags'])
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $popularTags = Tag::popular(15)->get();

        return view('blogs.by-tag', compact('blogs', 'tag', 'popularTags'));
    }
}
