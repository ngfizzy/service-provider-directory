# Service Provider Directory – Laravel Production Setup
![Screenshot](/Directomy.png)
This project is a Laravel-based directory of service providers, optimized for production deployment. It utilizes a Dockerized MySQL database and a streamlined shell script (`startup-prod.sh`) to automate the build, migration, and launch processes.

---

## ⚙ Project Overview

- **Framework**: Laravel 10
- **Database**: MySQL 8.0 (Dockerized)
- **Frontend**: Vite with Vue 3 and Tailwind CSS
- **PHP Version**: 8.3.x
- **Deployment**: Manual script-based setup with Docker Compose for the database

---

## Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/ngfizzy/service-provider-directory.git
cd service-provider-directory
```

### 2. Configure Environment Variables

```bash
cp .env.example .env
```

Edit `.env` to match your local setup:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 3. Start the MySQL Docker Container

```bash
docker-compose up -d
```

### 4. Run the Production Startup Script

```bash
chmod +x startup-prod.sh
./startup-prod.sh
```

---

## 🛠️ Design Decisions

- **Stack**: Laravel backend with Inertia, Vue 3, and Tailwind CSS on the frontend
- **Authentication**: Laravel Breeze (Inertia) for login-protected pages
- **Models**: Category and ServiceProvider, with a `belongsTo` relationship
- **Async-loaded Category Filter**: `vue-multiselect` with debounced API search
- **Server-side Filtering**: Efficient `WHERE category_id = ...` on controller level
- **Pagination**: 12 providers per page with Laravel pagination and preserved filters
- **Seeding Strategy**: Factory-generated categories and providers for testing realism
- **Docker Use**: MySQL in Docker; Laravel app runs locally with build script

---

## ⚡ Performance Optimizations

- **Eager Loading**: Avoids N+1 by eager-loading categories with service providers
- **Debounced Async Search**: Limits API calls while typing category filters
- **Lazy-loaded Images**: `loading="lazy"` for provider logos
- **Pagination**: Minimizes payload and database load per request
- **Minified Assets**: Vite compiles and extracts vendor bundles with Tailwind purging
- **Lazy-loading Vue Components**: Dynamically import filters for reduced bundle siz
- **Right Indexing And Constraints**: Ensure proper indexing on `category_id` and other frequently queried fields
- **Laravel Optimization**:
  - `php artisan config:cache`
  - `php artisan route:cache`
  - `php artisan view:cache`
  - `composer install --no-dev --optimize-autoloader`

---

## 🔭 Areas for Future Enhancement
- **Scalable Search**: Integrate Laravel Scout + MeiliSearch/Algolia for fuzzy search
- **Server-side Cache**: Cache frequent queries with Redis or Laravel Cache
- **Asset/Image Optimization**: Use WebP, image compression, and possibly a CDN
- **Testing & CI**: Expand tests and integrate into CI/CD workflows
- **Improved Seeding & UX**: Smarter test data and better filtering controls



