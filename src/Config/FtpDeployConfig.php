<?php

declare(strict_types=1);

namespace FtpDeploy\Config;

final class FtpDeployConfig
{
    /**
     * @param  list<string>  $allowedEnvironments
     */
    public function __construct(
        public readonly string $configFile,
        public readonly array $allowedEnvironments,
    ) {
    }

    /**
     * @param  array<string, mixed>  $config
     */
    public static function fromArray(array $config): self
    {
        $allowed = $config['allowed_environments'] ?? ['local'];
        if (! is_array($allowed)) {
            $allowed = ['local'];
        }

        return new self(
            configFile: (string) ($config['config_file'] ?? '.ftp-deploy'),
            allowedEnvironments: array_values(array_map('strval', $allowed)),
        );
    }

    public function isEnvironmentAllowed(string $environment): bool
    {
        return in_array($environment, $this->allowedEnvironments, true);
    }
}
