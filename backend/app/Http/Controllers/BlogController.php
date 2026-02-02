<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BlogController extends Controller
{

    /**
     * Display a listing of the user's blogs.
     */
    public function index(): View
    {
        $blogs = Auth::user()->blogs()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog.
     */
    public function create(): View
    {
        return view('blogs.create');
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

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('blog-images', 'public');
            $validated['featured_image'] = $path;
        }

        // Set published_at if publishing
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $blog = Blog::create($validated);

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

        return view('blogs.edit', compact('blog'));
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
                Storage::disk('public')->delete($blog->featured_image);
            }
            $path = $request->file('featured_image')->store('blog-images', 'public');
            $validated['featured_image'] = $path;
        }

        // Handle status change
        if ($validated['status'] === 'published' && !$blog->isPublished()) {
            $validated['published_at'] = now();
        } elseif ($validated['status'] === 'draft') {
            $validated['published_at'] = null;
        }

        $blog->update($validated);

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
            Storage::disk('public')->delete($blog->featured_image);
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
            Storage::disk('public')->delete($blog->featured_image);
            $blog->update(['featured_image' => null]);
        }

        return redirect()->back()->with('success', 'Image removed successfully.');
    }
}
