<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class CategoryTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default categories
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology', 'color' => '#3b82f6', 'description' => 'Tech news, tutorials, and innovations', 'sort_order' => 1],
            ['name' => 'Lifestyle', 'slug' => 'lifestyle', 'color' => '#ec4899', 'description' => 'Health, wellness, and daily life tips', 'sort_order' => 2],
            ['name' => 'Business', 'slug' => 'business', 'color' => '#10b981', 'description' => 'Entrepreneurship, finance, and career advice', 'sort_order' => 3],
            ['name' => 'Travel', 'slug' => 'travel', 'color' => '#f59e0b', 'description' => 'Adventures, destinations, and travel guides', 'sort_order' => 4],
            ['name' => 'Food', 'slug' => 'food', 'color' => '#ef4444', 'description' => 'Recipes, reviews, and culinary discoveries', 'sort_order' => 5],
            ['name' => 'Education', 'slug' => 'education', 'color' => '#8b5cf6', 'description' => 'Learning resources and educational content', 'sort_order' => 6],
            ['name' => 'Entertainment', 'slug' => 'entertainment', 'color' => '#f97316', 'description' => 'Movies, music, games, and pop culture', 'sort_order' => 7],
            ['name' => 'Science', 'slug' => 'science', 'color' => '#06b6d4', 'description' => 'Scientific discoveries and research', 'sort_order' => 8],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }

        // Create default tags
        $tags = [
            ['name' => 'Programming', 'slug' => 'programming', 'color' => '#6366f1'],
            ['name' => 'Web Development', 'slug' => 'web-development', 'color' => '#3b82f6'],
            ['name' => 'JavaScript', 'slug' => 'javascript', 'color' => '#eab308'],
            ['name' => 'PHP', 'slug' => 'php', 'color' => '#8b5cf6'],
            ['name' => 'Laravel', 'slug' => 'laravel', 'color' => '#ef4444'],
            ['name' => 'React', 'slug' => 'react', 'color' => '#06b6d4'],
            ['name' => 'Tips', 'slug' => 'tips', 'color' => '#10b981'],
            ['name' => 'Tutorial', 'slug' => 'tutorial', 'color' => '#f97316'],
            ['name' => 'News', 'slug' => 'news', 'color' => '#64748b'],
            ['name' => 'Opinion', 'slug' => 'opinion', 'color' => '#ec4899'],
            ['name' => 'Review', 'slug' => 'review', 'color' => '#14b8a6'],
            ['name' => 'Guide', 'slug' => 'guide', 'color' => '#a855f7'],
            ['name' => 'Beginner', 'slug' => 'beginner', 'color' => '#22c55e'],
            ['name' => 'Advanced', 'slug' => 'advanced', 'color' => '#dc2626'],
            ['name' => 'Career', 'slug' => 'career', 'color' => '#0ea5e9'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['slug' => $tag['slug']], $tag);
        }
    }
}
