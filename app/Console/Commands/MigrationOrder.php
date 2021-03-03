<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrationOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:all:ordered';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate tables in order';

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
    public function handle(): void
    {
        $migrations = [
            '2014_10_12_000000_create_users_table.php',
            '2019_12_14_000001_create_personal_access_tokens_table.php',
            '2021_01_11_134950_create_maps_table.php',
            '2021_01_11_135004_create_cities_table.php',
            '2021_01_11_135111_map__city.php',
            '2021_01_11_135908_create_highscores_table.php',
            ];

        foreach($migrations as $migration)
        {
            try {
            $basePath = 'database/migrations/';
            $migrationName = trim($migration);
            $path = $basePath . $migrationName;
            Artisan::call('migrate:refresh', [
                '--path' => $path ,
            ]);
                $this->getOutput()->writeln($migrationName . " migrated successfully!");
            } catch (\Exception $e) {
                $this->getOutput()->writeln('Failed to migrate!');
                $this->getOutput()->writeln($e->getMessage());
            }
        }
    }
}
