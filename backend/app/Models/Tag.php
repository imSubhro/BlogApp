<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'color',
    ];

    /**
     * Get the blogs that have this tag.
     */
    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'blog_tag')->withTimestamps();
    }

    /**
     * Get only published blogs with this tag.
     */
    public function publishedBlogs(): BelongsToMany
    {
        return $this->blogs()->published();
    }

    /**
     * Generate a unique slug from the name.
     */
    public static function generateSlug(string $name, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        $query = static::where('slug', $slug);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
            
            $query = static::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    /**
     * Get the published blog count for this tag.
     */
    public function getPublishedBlogsCountAttribute(): int
    {
        return $this->publishedBlogs()->count();
    }

    /**
     * Find or create a tag by name.
     */
    public static function findOrCreateByName(string $name): self
    {
        $slug = Str::slug($name);
        
        return static::firstOrCreate(
            ['slug' => $slug],
            ['name' => trim($name), 'slug' => $slug]
        );
    }

    /**
     * Scope to get popular tags (by blog count).
     */
    public function scopePopular($query, int $limit = 10)
    {
        return $query->withCount(['blogs' => function ($q) {
            $q->published();
        }])
        ->orderByDesc('blogs_count')
        ->limit($limit);
    }
}
