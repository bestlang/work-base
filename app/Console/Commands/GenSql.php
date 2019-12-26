<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenSql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:sql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get sql of migration files';

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
        //
        $migrator = app('migrator');
        $db = $migrator->resolveConnection(null);
        $migrations = $migrator->getMigrationFiles('database/migrations');
        $migrator->requireFiles($migrations);
        $queries = [];

        foreach($migrations as $migration) {
            $migration_name = $migration;
            $migration_name = str_replace('.php', '', $migration_name);
            $migration = $migrator->resolve($migration_name);

            $queries[] = [
                'name' => $migration_name,
                'queries' => array_column($db->pretend(function() use ($migration) { $migration->up(); }), 'query'),
            ];
        }
        dd($queries);
    }
}
