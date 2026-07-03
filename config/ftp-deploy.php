<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Config file
    |--------------------------------------------------------------------------
    |
    | Path to a local credentials file in the project root (.ftp-deploy).
    | Not committed to git — for dev machines only.
    |
    */
    'config_file' => '.ftp-deploy',

    /*
    |--------------------------------------------------------------------------
    | Allowed environments
    |--------------------------------------------------------------------------
    |
    | The deploy command refuses to run outside these APP_ENV values.
    |
    */
    'allowed_environments' => ['local'],
];
