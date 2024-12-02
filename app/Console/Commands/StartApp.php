<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class StartApp extends Command
{
    protected $signature = 'start:app';

    protected $description = 'Run commands to start the Laravel application';

    public function handle()
    {
        $commands = [
            'cp .env.example .env',
            'composer install',
            'npm install',
            'npm run build',
            'php artisan optimize:clear',
            'php artisan key:generate',
            'php artisan config:cache',
            'php artisan db:create task_management_system',
            'php artisan migrate:fresh --seed',
            'php artisan serve',
        ];

        foreach ($commands as $command) {
            $process = new Process(explode(' ', $command));
            $process->setTimeout(null);
            $process->setWorkingDirectory(base_path());
            $process->run(function ($type, $buffer) {
                $this->output->write($buffer);
            });

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
        }

        $this->info('Application started!');
    }
}
