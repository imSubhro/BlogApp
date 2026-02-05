<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Store a newly created comment.
     */
    public function store(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:3|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        // If replying, verify the parent comment belongs to the same blog
        if ($validated['parent_id'] ?? null) {
            $parentComment = Comment::findOrFail($validated['parent_id']);
            if ($parentComment->blog_id !== $blog->id) {
                abort(422, 'Invalid parent comment.');
            }
        }

        $comment = $blog->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Comment posted successfully!')
            ->withFragment('comment-' . $comment->id);
    }

    /**
     * Update the specified comment.
     */
    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string|min:3|max:1000',
        ]);

        $comment->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Comment updated successfully!')
            ->withFragment('comment-' . $comment->id);
    }

    /**
     * Remove the specified comment.
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $blogSlug = $comment->blog->slug;
        $comment->delete();

        return redirect()
            ->route('blogs.single', $blogSlug)
            ->with('success', 'Comment deleted successfully!');
    }
}
