<?php

namespace Davidhsianturi\Compass\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compass:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Compass resources';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Publishing Compass Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'compass-assets']);

        $this->comment('Publishing Compass Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'compass-config']);

        $this->info('Compass scaffolding installed successfully.');
    }
}
