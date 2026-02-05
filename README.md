# BlogApp 📝

A modern, premium multi-user blog platform built with Laravel, Blade, and Tailwind CSS.

![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg?style=for-the-badge&logo=php)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC.svg?style=for-the-badge&logo=tailwind-css)
![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)

---

## 🌟 Why Use BlogApp?

BlogApp isn't just another CRUD application. It's a polished, publication-ready platform designed for both writers and readers.

- **🎨 Premium UI/UX Design**: Built with a focus on aesthetics, featuring glassmorphism, animated gradients, smooth transitions, and a clean typography hierarchy that feels modern and professional.
- **⚡ Full-Stack Functionality**: Everything you need is built-in. From authentication to comments, category management to author profiles—no extra plugins required.
- **🛠️ Developer Friendly**: Written in clean, modern Laravel (v11+) with standard practices, making it easy to extend, customize, and deploy.
- **📱 Responsive First**: A mobile-optimized experience ensuring your content looks stunning on desktops, tablets, and phones alike.

---

## 🔥 Main Features

### ✍️ Advanced Content Management
- **Rich Blog Creation**: Create and edit blogs with a clean interface.
- **Draft System**: Work on your ideas in private with "Draft" status before going "Live".
- **Media Support**: Drag-and-drop featured image uploads with instant previews.
- **Smart Extracts**: Auto-generated excerpts for your blog listings.

### 🗂️ Powerful Organization
- **Categories System**: Color-coded categories (e.g., Technology, Lifestyle) for easy navigation.
- **Tagging Engine**: Add and manage multiple tags per post for granular filtering.
- **Smart Filtering**: Filter content by Category, Tag, or Author with dedicated route pages.
- **Global Search**: Find any article instantly with the built-in search bar.

### 💬 Community & Engagement
- **Threaded Comments**: Deep nesting support for discussions with reply functionality.
- **Author Profiles**: Beautiful public profile pages for every author showing their stats and article history.
- **Social Features**: Read time estimates and "New" / "Updated" badges.

### 📊 Dashboard & Analytics
- **Personal Dashboard**: At-a-glance view of your Total Blogs, Published posts, and Drafts.
- **Publish Rate**: visual progress bar tracking your writing consistency.
- **Quick Actions**: One-click access to create, manage, or edit your profile.
- **Status Indicators**: Visual pulse indicators for live vs. draft content.


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

## 🎨 Tech Stack

- **Backend**: Laravel 12.x
- **Frontend**: Blade Templates + Tailwind CSS
- **Authentication**: Laravel Breeze
- **Database**: PostgreSQL
- **Build Tool**: Vite
- **Icons**: Heroicons (inline SVG)


## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

---

Built with ❤️ by imSubhro.
