<?php

namespace NoaPe\Beluga\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallBelugaPackage extends Command
{
    protected $signature = 'beluga:install';

    protected $description = 'Install the BelugaPackage';

    public function handle()
    {
        $this->info('Installing BelugaPackage...');

        $this->info('Publishing configuration...');

        if (! $this->configExists('config.php')) {
            $this->publishConfiguration();
            $this->info('Published configuration');
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting configuration file...');
                $this->publishConfiguration($force = true);
            } else {
                $this->info('Existing configuration was not overwritten');
            }
        }

        $this->info('Installed BelugaPackage');
    }

    private function configExists($fileName)
    {
        return File::exists(config_path($fileName));
    }

    private function shouldOverwriteConfig()
    {
        return $this->confirm(
            'Config file already exists. Do you want to overwrite it?',
            false
        );
    }

    private function publishConfiguration($forcePublish = false)
    {
        $params = [
            '--provider' => "NoaPe\Beluga\BelugaPackageServiceProvider",
            '--tag' => "config"
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

       $this->call('vendor:publish', $params);
    }
}