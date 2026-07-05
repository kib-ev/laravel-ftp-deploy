# kib-ev/laravel-ftp-deploy

Artisan command `php artisan deploy` for uploading project files to shared hosting via FTP.

**Local development only:** the command runs when `APP_ENV=local`. Credentials are stored in `.ftp-deploy` (not committed to git).

Repository: [github.com/kib-ev/laravel-ftp-deploy](https://github.com/kib-ev/laravel-ftp-deploy)

## Requirements

- PHP 8.1+
- ext-ftp

## Installation

```bash
composer require --dev kib-ev/laravel-ftp-deploy
```

On production with `composer install --no-dev`, the package is not installed.

## Configuration

Copy the example file to your Laravel project root:

```bash
cp vendor/kib-ev/laravel-ftp-deploy/.ftp-deploy.example .ftp-deploy
```

`.ftp-deploy`:

```ini
host=ftp.example.com
username=user
password=secret
port=21
root=/sites/example.com
ssl=false
passive=true
```

Add to your project `.gitignore`:

```
.ftp-deploy
```

## Usage

```bash
php artisan deploy --file=public/index.php
php artisan deploy --file=.env.production:.env
php artisan deploy --dir=app/Http/Controllers
```

## AI-assisted workflow (Cursor, etc.)

This package works well with AI-powered editors such as [Cursor](https://cursor.com). After you change code locally, ask the agent to deploy only the modified files — no separate deployment pipeline required.

Example prompts:

- *"Deploy the changed files to production via FTP"*
- *"Run `php artisan deploy` for `routes/web.php` and `app/Http/Controllers/OrderController.php`"*
- *"Upload `.env.production` as `.env` on the server"*

The agent can run `php artisan deploy --file=...` for individual paths or `--dir=...` for whole directories. Credentials stay in your local `.ftp-deploy` file and are never committed to git.

## Local development (path repository)

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "../laravel-ftp-deploy"
        }
    ],
    "require-dev": {
        "kib-ev/laravel-ftp-deploy": "*"
    }
}
```

## License

MIT
