<?php

namespace App\Console\Commands;

use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class GenerateApplicationMasterId extends Command
{
    use ConfirmableTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:appmasterid
                    {--show : Display the master id instead of modifying files}
                    {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Application Master Id to authorize admin client requests';

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
     * @return void
     */
    public function handle()
    {
        // Generate appMasterId
        $appMasterId = $this->generateRandomKey();
        $oldId = config('imbaas_ids.applicationMasterId');

        if ($this->option('show')) {
            $this->line('<comment>'.$appMasterId.'</comment>');
            return;
        }
        $path = base_path('.env');

        $config_path = base_path('/config/imbaas_ids.php');

        if (file_exists($path)) {
            // check if there is already a id set first
            if (! Str::contains(file_get_contents($path), 'API_APPLICATION_MASTER_ID')) {
                file_put_contents($path, PHP_EOL."API_APPLICATION_MASTER_ID=$appMasterId", FILE_APPEND);
                if (file_exists($config_path)) {
                    $this->replaceStringInFile($config_path, $oldId, $appMasterId);
                }
            } else {
                // let's be sure you want to do this, unless you already told us to force it
                $confirmed = $this->option('force') || $this->confirm('This will invalidate all existing clients requests. Are you sure you want to override the application master id?');

                if ($confirmed) {
                    file_put_contents($path, str_replace(
                        'API_APPLICATION_MASTER_ID='.$this->laravel['config']['imbaas_ids.applicationMasterId'], 'API_APPLICATION_MASTER_ID='.$appMasterId, file_get_contents($path)
                    ));
                    if (file_exists($config_path)) {
                        $this->replaceStringInFile($config_path, $oldId, $appMasterId);
                    }
                } else {
                    $this->comment('Phew... No changes were made to your application master id.');
                    return;
                }
            }
        }
        $this->info("API Application Master Id [$appMasterId] set successfully.");

    }

    /**
     * Generate a random appId for the application.
     *
     * @return string
     */

    protected function generateRandomKey() {
        return Str::random(config('imbaas_ids.applicationMasterIdLength'));
    }

    protected function replaceStringInFile($file, $oldString, $newString)
    {
        $fileContents = file_get_contents($file);
        $fileContents = str_replace("$oldString", "$newString",$fileContents);
        file_put_contents($file, $fileContents);
    }
}
