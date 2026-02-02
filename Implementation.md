You are a senior Laravel engineer and technical writer.

Your task is to generate a complete a FULL-STACK BLOG WEBSITE built using Laravel + Blade + Tailwind CSS + Laravel Breeze.

IMPORTANT RULES:
1. The implementation must be written STEP BY STEP from TOP TO BOTTOM.
2. Each step must be completed before moving to the next.
3. Do NOT skip steps or assume prior setup.
4. Do NOT jump ahead.
5. Each step must include:
   - Purpose of the step
   - Commands to run (if any)
   - Files to create or modify
   - Code snippets (only what is needed)
   - Clear explanation of what was achieved
6. The tone should be practical, beginner-friendly, and production-oriented.
7. The output must ONLY be the contents of `implementation.md`.

PROJECT DESCRIPTION:
We are building a multi-user blog platform where:
- Users can register and log in
- After login, users get a personal dashboard
- Users can create, edit, delete, publish, and unpublish blogs
- Blogs belong to the logged-in user
- Public users can view published blogs
- The platform uses Laravel Breeze for authentication
- Blade + Tailwind CSS are used for the frontend
- PostgreSQL is used as the database
- Only images are stored (no video or large storage)

TECH STACK:
- Laravel (latest stable)
- Laravel Breeze (Blade)
- Tailwind CSS
- PostgreSQL
- PHP 8+

IMPLEMENTATION MUST INCLUDE THE FOLLOWING STEPS IN ORDER:

Step 1: Project initialization
- Creating Laravel project
- Environment setup
- Database configuration
- Running initial migrations

Step 2: Authentication setup using Laravel Breeze
- Installing Breeze
- Understanding generated routes, controllers, views
- Verifying login, register, logout flow

Step 3: Application layout & navigation
- Layout structure
- Navbar changes for auth/guest
- Dashboard routing

Step 4: Blog database design
- Blog migration
- Blog model
- Relationships with User model

Step 5: Blog CRUD functionality
- BlogController creation
- Create, store, edit, update, delete logic
- Slug generation
- Validation rules

Step 6: User dashboard
- Showing logged-in user’s blogs
- Draft vs published separation
- Basic stats (count only)

Step 7: Blog writing UI
- Create/edit blog forms
- Tailwind styling
- Status selection (draft/published)

Step 8: Public blog pages
- Blog listing page
- Single blog page
- Only published blogs visible
- SEO-friendly URLs using slug

Step 9: Authorization & security
- Ensuring users can only edit their own blogs
- Route protection using middleware

Step 10: Polishing & best practices
- Folder structure
- Naming conventions
- Common mistakes to avoid
- Ready-for-deployment checklist

FINAL OUTPUT FORMAT:
- Markdown (.md)
- Clear headings
- Code blocks where required
- No unnecessary theory
- No missing steps

