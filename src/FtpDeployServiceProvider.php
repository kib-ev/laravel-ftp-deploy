<?php

declare(strict_types=1);

namespace FtpDeploy;

use FtpDeploy\Config\FtpDeployConfig;
use FtpDeploy\Console\FtpDeployCommand;
use Illuminate\Support\ServiceProvider;

class FtpDeployServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ftp-deploy.php', 'ftp-deploy');

        $this->app->singleton(FtpDeployConfig::class, function ($app): FtpDeployConfig {
            /** @var array<string, mixed> $config */
            $config = $app['config']->get('ftp-deploy', []);

            return FtpDeployConfig::fromArray($config);
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/ftp-deploy.php' => config_path('ftp-deploy.php'),
            ], 'ftp-deploy-config');

            $this->commands([
                FtpDeployCommand::class,
            ]);
        }
    }
}
