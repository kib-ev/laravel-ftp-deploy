# kib-ev/laravel-ftp-deploy

Artisan-команда `php artisan deploy` для выкладки файлов Laravel-проекта на shared-хостинг по FTP.

Репозиторий: [github.com/kib-ev/laravel-ftp-deploy](https://github.com/kib-ev/laravel-ftp-deploy)

## Требования

- PHP 8.1+
- ext-ftp

## Установка

```bash
composer require kib-ev/laravel-ftp-deploy
```

Опубликуйте конфиг (опционально):

```bash
php artisan vendor:publish --tag=ftp-deploy-config
```

## Настройка

По умолчанию учётные данные читаются из `.env.local` в корне проекта (отдельно от основного `.env`):

```env
DEPLOY_FTP_HOST=ftp.example.com
DEPLOY_FTP_USERNAME=user
DEPLOY_FTP_PASSWORD=secret
DEPLOY_FTP_PORT=21
DEPLOY_FTP_ROOT=/sites/example.com
DEPLOY_FTP_SSL=false
DEPLOY_FTP_PASSIVE=true
```

Либо задайте `DEPLOY_FTP_*` в основном `.env` — тогда `.env.local` не нужен.

Путь к файлу с credentials: `FTP_DEPLOY_ENV_FILE=.env.local` (в `config/ftp-deploy.php`).

## Использование

```bash
# один файл
php artisan deploy --file=public/index.php

# локальное имя → удалённое (например .env.production → .env)
php artisan deploy --file=.env.production:.env

# все файлы в каталоге рекурсивно
php artisan deploy --dir=app/Http/Controllers

# несколько путей
php artisan deploy --file=routes/web.php --dir=config
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
    "require": {
        "kib-ev/laravel-ftp-deploy": "*"
    }
}
```

## Лицензия

MIT
