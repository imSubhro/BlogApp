<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can view any comments.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Anyone can view comments
    }

    /**
     * Determine whether the user can view the comment.
     */
    public function view(?User $user, Comment $comment): bool
    {
        return $comment->is_approved || ($user && $user->id === $comment->user_id);
    }

    /**
     * Determine whether the user can create comments.
     */
    public function create(User $user): bool
    {
        return true; // Any authenticated user can comment
    }

    /**
     * Determine whether the user can update the comment.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can delete the comment.
     */
    public function delete(User $user, Comment $comment): bool
    {
        // User can delete their own comment OR the blog owner can delete any comment on their blog
        return $user->id === $comment->user_id || $user->id === $comment->blog->user_id;
    }

    /**
     * Determine whether the user can reply to a comment.
     */
    public function reply(User $user, Comment $comment): bool
    {
        return $comment->is_approved; // Can only reply to approved comments
    }
}
