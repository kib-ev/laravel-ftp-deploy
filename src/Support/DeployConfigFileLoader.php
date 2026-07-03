<?php

declare(strict_types=1);

namespace FtpDeploy\Support;

use Dotenv\Dotenv;
use RuntimeException;

final class DeployConfigFileLoader
{
    /**
     * @return array{
     *     host: string,
     *     username: string,
     *     password: string,
     *     port: int,
     *     root: string,
     *     ssl: bool,
     *     passive: bool,
     * }
     */
    public static function load(string $basePath, string $configFile): array
    {
        $path = $basePath.DIRECTORY_SEPARATOR.ltrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $configFile), DIRECTORY_SEPARATOR);

        if (! is_readable($path)) {
            throw new RuntimeException(
                "{$configFile} not found. Copy .ftp-deploy.example to {$configFile} and set FTP credentials."
            );
        }

        $vars = Dotenv::parse(file_get_contents($path));

        $host = self::value($vars, 'host', 'DEPLOY_FTP_HOST');
        $username = self::value($vars, 'username', 'DEPLOY_FTP_USERNAME');
        $password = self::value($vars, 'password', 'DEPLOY_FTP_PASSWORD');

        if ($host === '' || $username === '' || $password === '') {
            throw new RuntimeException(
                "Set host, username, and password in {$configFile}."
            );
        }

        $root = self::value($vars, 'root', 'DEPLOY_FTP_ROOT', '/');
        $root = '/'.trim(str_replace('\\', '/', $root), '/');
        if ($root === '/') {
            $root = '';
        }

        return [
            'host' => $host,
            'username' => $username,
            'password' => $password,
            'port' => (int) (self::value($vars, 'port', 'DEPLOY_FTP_PORT', '21') ?: 21),
            'root' => $root,
            'ssl' => filter_var(self::value($vars, 'ssl', 'DEPLOY_FTP_SSL', 'false'), FILTER_VALIDATE_BOOLEAN),
            'passive' => filter_var(self::value($vars, 'passive', 'DEPLOY_FTP_PASSIVE', 'true'), FILTER_VALIDATE_BOOLEAN),
        ];
    }

    /**
     * @param  array<string, string|null>  $vars
     */
    private static function value(array $vars, string $key, string $legacyKey, string $default = ''): string
    {
        foreach ([$key, $legacyKey] as $name) {
            if (isset($vars[$name]) && $vars[$name] !== null && $vars[$name] !== '') {
                return trim((string) $vars[$name], " \t\n\r\0\x0B\"'");
            }
        }

        return $default;
    }
}
