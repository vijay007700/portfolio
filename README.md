# Laravel / PHP Developer Portfolio

A responsive Laravel portfolio with a Blade public site, a MySQL-compatible database, an authenticated admin panel, project case-study pages, a public JSON API and a contact inbox.

## Stack

- Laravel 13, PHP 8.3+
- Blade templates, vanilla CSS and JavaScript (no frontend build step)
- MySQL in production; SQLite is configured for quick local setup
- Session authentication for the admin area

## Local setup

Requirements: PHP 8.3+, Composer 2, MySQL (or SQLite for a quick local run), and PHP extensions for PDO, mbstring, OpenSSL, tokenizer and fileinfo.

```bash
composer install
cp .env.example .env
# Set DB_* values in .env for your MySQL database
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

For a quick local SQLite run instead, set `DB_CONNECTION=sqlite`, remove/comment the `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` values, then run `touch database/database.sqlite`.

Open `http://127.0.0.1:8000`. The admin panel is at `/admin/login`.

Development login from `.env.example`:

```text
Email: admin@portfolio.test
Password: Admin@123
```

Change `ADMIN_EMAIL` and `ADMIN_PASSWORD` in `.env` before seeding a production database. Do not deploy the sample credentials.

`./install.sh` runs the same setup steps for a fresh checkout.

## MySQL setup

Create an empty MySQL database, then update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolio
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

Then run:

```bash
php artisan migrate --seed
```

The migrations create users, profile, skills, work history, services, projects and case-study content, integrations, testimonials, contact messages and site settings. Project screenshots are stored as uploaded files under `public/uploads`; project metadata and screenshot paths are stored in MySQL/SQLite.

## Admin content

1. Sign in at `/admin/login`.
2. Update Profile with your real introduction, email, LinkedIn, Upwork and other links.
3. Add your actual experience and skills.
4. Edit or remove the sample projects. Project forms support category, overview, problem, solution, responsibilities, technology list, screenshots, live URL, featured/published flags and SEO metadata.
5. Add only project details and client screenshots you have permission to publish. Sample projects are marked as demos in the public site.
6. Update SEO and site settings before launch.

No invented employment history or testimonials are seeded. Replace all sample identity text before publishing.

## Public pages

- `/` Home, introduction, services and featured projects
- `/about` Background and work approach
- `/skills` Technical skills
- `/services` Services
- `/work` Filterable portfolio
- `/work/{slug}` Project case study
- `/experience` Professional background
- `/integrations` Technologies and integrations
- `/contact` Contact links and enquiry form
- `/sitemap.xml` XML sitemap for published pages and projects

## API v1

JSON endpoints are available under `/api/v1`:

| Method | Endpoint | Description |
| --- | --- | --- |
| GET | `/api/v1/profile` | Public profile and contact links |
| GET | `/api/v1/projects` | Published projects; accepts `category`, `featured=1`, `per_page`, `page` |
| GET | `/api/v1/projects/{slug}` | Published project case study |
| GET | `/api/v1/skills` | Active skills grouped by category |
| GET | `/api/v1/services` | Active services |
| GET | `/api/v1/experience` | Work history |
| GET | `/api/v1/integrations` | Active integrations |
| GET | `/api/v1/testimonials` | Active testimonials |
| POST | `/api/v1/contact` | Validate and save an enquiry (8 requests/minute) |

The contact API accepts JSON fields `name`, `email`, `company`, `budget`, `project_type`, and `message`. It returns HTTP 201 when the enquiry is saved. Validation errors are returned as JSON when the request sends `Accept: application/json`.

## Production deployment

- Point the web server document root to this project's `public/` folder.
- Set `APP_ENV=production`, `APP_DEBUG=false`, a production `APP_URL`, and strong database/admin credentials.
- Run `php artisan key:generate` once for the production environment, then `php artisan migrate --force --seed`.
- In production, the seeder creates an admin account only when a unique `ADMIN_EMAIL` and `ADMIN_PASSWORD` are configured. If either is missing, it skips admin creation and logs a warning so the public site can still start; configure both before using the dashboard.
- The Render Blueprint enables starter portfolio content for an empty database with `SEED_PORTFOLIO_CONTENT=true`; set it to `false` if you want to publish an empty portfolio instead.
- Configure writable `storage/` and `bootstrap/cache/` directories, HTTPS, database backups and log rotation.
- Do not commit `.env`, production credentials, private client data or confidential screenshots.
