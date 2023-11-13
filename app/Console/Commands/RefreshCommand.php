<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Storage::deleteDirectory('images/poster');
        Storage::deleteDirectory('images/gallery');

        $this->call('migrate:refresh', [
            '--seed' => true
        ]);
        return self::SUCCESS;
    }
}
