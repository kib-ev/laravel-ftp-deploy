<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Credentials file
    |--------------------------------------------------------------------------
    |
    | Path to an env file with FTP credentials, relative to the project root.
    | Keeps deploy secrets separate from the main .env (e.g. .env.local).
    |
    */
    'env_file' => env('FTP_DEPLOY_ENV_FILE', '.env.local'),

    /*
    |--------------------------------------------------------------------------
    | FTP connection (optional — overrides env file when set in main .env)
    |--------------------------------------------------------------------------
    */
    'host' => env('DEPLOY_FTP_HOST'),
    'username' => env('DEPLOY_FTP_USERNAME'),
    'password' => env('DEPLOY_FTP_PASSWORD'),
    'port' => (int) env('DEPLOY_FTP_PORT', 21),
    'root' => env('DEPLOY_FTP_ROOT', '/'),
    'ssl' => filter_var(env('DEPLOY_FTP_SSL', false), FILTER_VALIDATE_BOOLEAN),
    'passive' => filter_var(env('DEPLOY_FTP_PASSIVE', true), FILTER_VALIDATE_BOOLEAN),
];
