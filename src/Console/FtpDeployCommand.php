<?php

declare(strict_types=1);

namespace FtpDeploy\Console;

use FtpDeploy\Config\FtpDeployConfig;
use FtpDeploy\FtpDeployService;
use FtpDeploy\Support\DeployConfigFileLoader;
use Illuminate\Console\Command;
use Throwable;

class FtpDeployCommand extends Command
{
    protected $signature = 'deploy
                            {--file=* : File path relative to project root (repeatable; use local:remote to rename)}
                            {--dir=* : Directory path relative to project root (upload all files recursively)}';

    protected $description = 'Upload files to remote hosting via FTP (local dev only)';

    public function handle(FtpDeployConfig $config): int
    {
        if (! $config->isEnvironmentAllowed(app()->environment())) {
            $allowed = implode(', ', $config->allowedEnvironments);
            $this->error("FTP deploy is only available when APP_ENV is: {$allowed}.");

            return self::FAILURE;
        }

        $files = $this->option('file');
        $dirs = $this->option('dir');

        if (
            ($files === null || $files === [] || (count($files) === 1 && $files[0] === null))
            && ($dirs === null || $dirs === [] || (count($dirs) === 1 && $dirs[0] === null))
        ) {
            $this->error('Specify at least one --file= or --dir= path.');

            return self::FAILURE;
        }

        try {
            $connection = DeployConfigFileLoader::load(base_path(), $config->configFile);
            $deployer = new FtpDeployService(base_path(), $connection);
            $uploads = [];

            foreach ($files ?? [] as $file) {
                if ($file === null || $file === '') {
                    continue;
                }

                [$local, $remote] = str_contains($file, ':')
                    ? explode(':', $file, 2)
                    : [$file, $file];
                $uploads[] = [$local, $remote, $local === $remote ? $local : "{$local} → {$remote}"];
            }

            foreach ($dirs ?? [] as $dir) {
                if ($dir === null || $dir === '') {
                    continue;
                }
                foreach ($deployer->filesInDirectory($dir) as $file) {
                    $uploads[] = [$file, $file, $file];
                }
            }

            if ($uploads === []) {
                $this->error('Nothing to upload after resolving --file/--dir options.');

                return self::FAILURE;
            }

            $this->info("Connecting to {$connection['host']}:{$connection['port']}…");
            $deployer->connect();
            $bar = $this->output->createProgressBar(count($uploads));
            $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %message%');
            $bar->setMessage('uploading…');
            $bar->start();

            foreach ($uploads as [$local, $remote, $label]) {
                $bar->setMessage($label);
                $deployer->uploadAs($local, $remote);
                $bar->advance();
            }

            $deployer->disconnect();
            $bar->finish();
            $this->newLine(2);
            $this->info('Done: uploaded '.count($uploads).' file(s).');

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
