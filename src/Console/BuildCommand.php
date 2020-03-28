<?php

namespace Davidhsianturi\Compass\Console;

use Illuminate\Console\Command;
use Davidhsianturi\Compass\Contracts\DocumenterRepository;

class BuildCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compass:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build an API documentation from existing Laravel routes';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(DocumenterRepository $docs)
    {
        $docs->build();

        $this->info('Building complete.');
    }
}
