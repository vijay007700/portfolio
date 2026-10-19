# Ubuntu setup

Install PHP 8.3+, Composer 2 and the extensions needed by the selected database driver. For MySQL, install `php-mysql`; for SQLite local setup, install `php-sqlite3`.

```bash
sudo apt update
sudo apt install -y php-cli php-mbstring php-xml php-curl php-mysql php-sqlite3 unzip
```

From the project directory:

```bash
composer install
cp .env.example .env
# Set DB_* values for a created MySQL database, or switch DB_CONNECTION to sqlite
php artisan key:generate
php artisan migrate --seed
php artisan serve --host=0.0.0.0 --port=8000
```

For SQLite, remove the MySQL `DB_*` values in `.env` and create the file with `touch database/database.sqlite` before migrating.

For Apache or Nginx, set the document root to this project's `public/` directory and ensure `storage/` and `bootstrap/cache/` are writable by the PHP process.
