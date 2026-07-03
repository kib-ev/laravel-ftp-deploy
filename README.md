# kib-ev/laravel-ftp-deploy

Artisan-команда `php artisan deploy` для выкладки файлов на shared-хостинг по FTP.

**Только для локальной разработки:** команда работает при `APP_ENV=local`, учётные данные хранятся в `.ftp-deploy` (не коммитится).

Репозиторий: [github.com/kib-ev/laravel-ftp-deploy](https://github.com/kib-ev/laravel-ftp-deploy)

## Требования

- PHP 8.1+
- ext-ftp

## Установка

```bash
composer require --dev kib-ev/laravel-ftp-deploy
```

На продакшене с `composer install --no-dev` пакет не устанавливается.

## Настройка

Скопируйте пример в корень Laravel-проекта:

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

Добавьте в `.gitignore` проекта:

```
.ftp-deploy
```

## Использование

```bash
php artisan deploy --file=public/index.php
php artisan deploy --file=.env.production:.env
php artisan deploy --dir=app/Http/Controllers
```

## Локальная разработка (path repository)

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

## Лицензия

MIT
