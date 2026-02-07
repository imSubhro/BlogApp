<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class BlogController extends Controller
{
    protected ImageUploadService $imageService;

    public function __construct(ImageUploadService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the user's blogs.
     */
    public function index(): View
    {
        $blogs = Auth::user()->blogs()
            ->with(['category', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog.
     */
    public function create(): View
    {
        $categories = Category::orderBy('sort_order')->get();
        $tags = Tag::orderBy('name')->get();
        
        return view('blogs.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created blog in storage.
     */
    public function store(StoreBlogRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Generate unique slug
        $validated['slug'] = Blog::generateSlug($validated['title']);
        $validated['user_id'] = Auth::id();

        // Handle featured image upload (supports Cloudinary on production)
        if ($request->hasFile('featured_image')) {
            $imagePath = $this->imageService->upload($request->file('featured_image'), 'blog-images');
            if ($imagePath) {
                $validated['featured_image'] = $imagePath;
            }
        }

        // Set published_at if publishing
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $blog = Blog::create($validated);

        // Sync tags if provided
        if ($request->has('tags')) {
            $tagIds = collect($request->input('tags'))->map(function ($tagInput) {
                // Handle both existing tag IDs and new tag names
                if (is_numeric($tagInput)) {
                    return (int) $tagInput;
                }
                // Create new tag if it's a name
                $tag = Tag::findOrCreateByName($tagInput);
                return $tag->id;
            })->toArray();
            
            $blog->tags()->sync($tagIds);
        }

        $message = $blog->isPublished() 
            ? 'Blog published successfully!' 
            : 'Blog saved as draft.';

        return redirect()->route('blogs.index')->with('success', $message);
    }

    /**
     * Display the specified blog (for owner preview).
     */
    public function show(Blog $blog): View
    {
        // Authorization check - ensure user owns the blog
        Gate::authorize('view', $blog);

        return view('blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified blog.
     */
    public function edit(Blog $blog): View
    {
        // Authorization check - ensure user owns the blog
        Gate::authorize('update', $blog);

        $categories = Category::orderBy('sort_order')->get();
        $tags = Tag::orderBy('name')->get();
        $selectedTags = $blog->tags->pluck('id')->toArray();
        
        return view('blogs.edit', compact('blog', 'categories', 'tags', 'selectedTags'));
    }

    /**
     * Update the specified blog in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog): RedirectResponse
    {
        // Authorization is handled in UpdateBlogRequest
        $validated = $request->validated();

        // Generate new slug if title changed
        if ($blog->title !== $validated['title']) {
            $validated['slug'] = Blog::generateSlug($validated['title'], $blog->id);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($blog->featured_image) {
                $this->imageService->delete($blog->featured_image);
            }
            $imagePath = $this->imageService->upload($request->file('featured_image'), 'blog-images');
            if ($imagePath) {
                $validated['featured_image'] = $imagePath;
            }
        }

        // Handle status change
        if ($validated['status'] === 'published' && !$blog->isPublished()) {
            $validated['published_at'] = now();
        } elseif ($validated['status'] === 'draft') {
            $validated['published_at'] = null;
        }

        $blog->update($validated);

        // Sync tags if provided
        if ($request->has('tags')) {
            $tagIds = collect($request->input('tags'))->map(function ($tagInput) {
                if (is_numeric($tagInput)) {
                    return (int) $tagInput;
                }
                $tag = Tag::findOrCreateByName($tagInput);
                return $tag->id;
            })->toArray();
            
            $blog->tags()->sync($tagIds);
        } else {
            $blog->tags()->detach();
        }

        $message = $blog->isPublished() 
            ? 'Blog updated and published!' 
            : 'Blog updated and saved as draft.';

        return redirect()->route('blogs.index')->with('success', $message);
    }

    /**
     * Remove the specified blog from storage.
     */
    public function destroy(Blog $blog): RedirectResponse
    {
        // Authorization check - ensure user owns the blog
        Gate::authorize('delete', $blog);

        // Delete featured image if exists
        if ($blog->featured_image) {
            $this->imageService->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }

    /**
     * Toggle publish status of the blog.
     */
    public function toggleStatus(Blog $blog): RedirectResponse
    {
        // Authorization check - ensure user owns the blog
        Gate::authorize('update', $blog);

        if ($blog->isPublished()) {
            $blog->unpublish();
            $message = 'Blog unpublished and saved as draft.';
        } else {
            $blog->publish();
            $message = 'Blog published successfully!';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove featured image from blog.
     */
    public function removeImage(Blog $blog): RedirectResponse
    {
        // Authorization check - ensure user owns the blog
        Gate::authorize('update', $blog);

        if ($blog->featured_image) {
            $this->imageService->delete($blog->featured_image);
            $blog->update(['featured_image' => null]);
        }

        return redirect()->back()->with('success', 'Image removed successfully.');
    }
}
