<?php

namespace Davidhsianturi\Compass\Console;

use Illuminate\Console\Command;
use Davidhsianturi\Compass\Contracts\DocumenterRepository;

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
    protected $description = 'Rebuild API documentation from existing markdown files';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(DocumenterRepository $docs)
    {
        if ($docs->rebuild() === false) {
            $this->error('There is no existing markdown files to rebuild, Try to run compass:build first.');

            return;
        }

        $this->info('Rebuilding complete.');
    }
}
