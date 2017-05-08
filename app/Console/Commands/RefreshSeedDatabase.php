<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class RefreshSeedDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:imbaas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh Migrations and Seed fake Data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("forget spatie's permission cache");
        Cache::forget('spatie.permission.cache');

        $this->info("Refresh migrations and seed fake data");
        Artisan::call('migrate:refresh', [
            "--seed" => true,
            "--force" => true]);

        $this->info("Data set successfully.");
    }
}
