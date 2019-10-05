<?php

namespace Davidhsianturi\Compass\Console;

use Illuminate\Console\Command;
use Davidhsianturi\Compass\Contracts\ApiDocsRepository;

class RebuildCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compass:rebuild';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuild your API documentation from your markdown file.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ApiDocsRepository $documentation)
    {
        if ($documentation->rebuild() === false) {
            $this->error('There is no existing markdown files to rebuild! Try to run compass:build first!');

            return;
        }

        $this->info('DONE!');
    }
}
