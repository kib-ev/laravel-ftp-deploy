<?php

declare(strict_types=1);

namespace FtpDeploy\Config;

final class FtpDeployConfig
{
    /**
     * @param  array{
     *     host: string,
     *     username: string,
     *     password: string,
     *     port: int,
     *     root: string,
     *     ssl: bool,
     *     passive: bool,
     * }  $connection
     */
    public function __construct(
        public readonly string $envFile,
        public readonly array $connection,
    ) {
    }

    /**
     * @param  array<string, mixed>  $config
     */
    public static function fromArray(array $config): self
    {
        $root = self::normalizeRoot((string) ($config['root'] ?? '/'));

        return new self(
            envFile: (string) ($config['env_file'] ?? '.env.local'),
            connection: [
                'host' => (string) ($config['host'] ?? ''),
                'username' => (string) ($config['username'] ?? ''),
                'password' => (string) ($config['password'] ?? ''),
                'port' => (int) ($config['port'] ?? 21),
                'root' => $root,
                'ssl' => (bool) ($config['ssl'] ?? false),
                'passive' => (bool) ($config['passive'] ?? true),
            ],
        );
    }

    public function hasConnectionInConfig(): bool
    {
        $connection = $this->connection;

        return $connection['host'] !== ''
            && $connection['username'] !== ''
            && $connection['password'] !== '';
    }

    private static function normalizeRoot(string $root): string
    {
        $root = '/'.trim(str_replace('\\', '/', $root), '/');

        return $root === '/' ? '' : $root;
    }
}
