# BlogApp 📝

A modern, multi-user blog platform built with Laravel, Blade, and Tailwind CSS.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC.svg)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-Latest-336791.svg)

## ✨ Features

- **User Authentication** - Register, login, logout, password reset (Laravel Breeze)
- **Personal Dashboard** - View stats, recent blogs, and quick actions
- **Blog Management** - Create, edit, delete, publish/unpublish blogs
- **Featured Images** - Upload and manage blog images
- **Draft System** - Save blogs as drafts before publishing
- **SEO Optimized** - Meta tags, Open Graph, Twitter Cards, JSON-LD
- **Public Blog Pages** - Browse and search published blogs
- **Author Profiles** - View blogs by specific authors
- **Mobile Responsive** - Beautiful UI on all devices
- **Security** - CSRF protection, XSS prevention, authorization policies

## 🚀 Quick Start

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & npm
- PostgreSQL

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd BlogApp/backend
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Update `.env` with your database credentials**
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=blogapp_db
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Create storage link**
   ```bash
   php artisan storage:link
   ```

8. **Build assets**
   ```bash
   npm run build
   ```

9. **Start development server**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` in your browser! 🎉

## 💻 Development

For development with hot reload:

```bash
# Terminal 1 - Laravel server
php artisan serve

# Terminal 2 - Vite dev server
npm run dev
```

## 📁 Project Structure

```
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── BlogController.php      # Blog CRUD operations
│   │   │   └── PublicBlogController.php # Public blog pages
│   │   ├── Middleware/
│   │   │   └── SecurityHeaders.php     # Security headers
│   │   └── Requests/
│   │       ├── StoreBlogRequest.php    # Blog creation validation
│   │       └── UpdateBlogRequest.php   # Blog update validation
│   ├── Models/
│   │   ├── Blog.php                    # Blog model
│   │   └── User.php                    # User model
│   └── Policies/
│       └── BlogPolicy.php              # Blog authorization
├── database/
│   └── migrations/                     # Database migrations
├── resources/
│   └── views/
│       ├── blogs/                      # Blog views
│       ├── dashboard.blade.php         # User dashboard
│       ├── welcome.blade.php           # Home page
│       └── errors/                     # Error pages
└── routes/
    └── web.php                         # Web routes
```

## 🛣️ Routes

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/` | home | Home page |
| GET | `/blogs` | blogs.public | Public blog listing |
| GET | `/blogs/{slug}` | blogs.single | Single blog view |
| GET | `/author/{id}` | blogs.by-author | Author's blogs |
| GET | `/dashboard` | dashboard | User dashboard |
| GET | `/my-blogs` | blogs.index | User's blogs |
| GET | `/my-blogs/create` | blogs.create | Create blog form |
| POST | `/my-blogs` | blogs.store | Store new blog |
| GET | `/my-blogs/{blog}/edit` | blogs.edit | Edit blog form |
| PUT | `/my-blogs/{blog}` | blogs.update | Update blog |
| DELETE | `/my-blogs/{blog}` | blogs.destroy | Delete blog |
| PATCH | `/my-blogs/{blog}/toggle-status` | blogs.toggle-status | Toggle publish status |

## 🔒 Security

- **CSRF Protection** - All forms include CSRF tokens
- **XSS Prevention** - Content escaped with Blade's `{{ }}`
- **Authorization** - BlogPolicy ensures users can only manage their own blogs
- **Form Validation** - Request validation with custom error messages
- **Security Headers** - X-Content-Type-Options, X-Frame-Options, X-XSS-Protection

## 🎨 Tech Stack

- **Backend**: Laravel 12.x
- **Frontend**: Blade Templates + Tailwind CSS
- **Authentication**: Laravel Breeze
- **Database**: PostgreSQL
- **Build Tool**: Vite
- **Icons**: Heroicons (inline SVG)

## 📦 Deployment Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure production database credentials
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Run `npm run build`
- [ ] Set up proper file permissions
- [ ] Configure web server (Nginx/Apache)
- [ ] Set up SSL certificate

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

---

Built with ❤️ using Laravel, Blade, and Tailwind CSS.
