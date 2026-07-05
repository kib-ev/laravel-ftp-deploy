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
