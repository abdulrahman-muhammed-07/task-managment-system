<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $databaseName = $this->argument('name') ?: config('database.connections.' . config('database.default') . '.database');

        $validator = Validator::make(['name' => $databaseName], [
            'name' => ['required', 'max:255', 'regex:/^[a-zA-Z0-9_]+$/'],
        ]);

        if ($validator->fails()) {
            return $this->error("Database $databaseName not created:" . $validator->errors()->first('name'));
        }

        config(['database.connections.' . config('database.default') . '.database' => null]);

        DB::statement('CREATE DATABASE IF NOT EXISTS ' . $databaseName);

        config(['database.connections.' . config('database.default') . '.database' => $databaseName]);

        $this->info('Database ' . $databaseName . ' created successfully.');

        return Command::SUCCESS;
    }
}
