<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ini_set('memory_limit', '1G');
        // set_time_limit(0);

        $userCount = 3;
        $tasksPerUser = 100;

        DB::transaction(function () use ($userCount, $tasksPerUser) {
            $users = User::factory($userCount)->create(
                ['password' => bcrypt('user')]
            );

            $users->each(function ($user) use ($tasksPerUser) {
                $tasks = [];

                $allUserIds = User::pluck('id')->toArray();

                for ($j = 0; $j < $tasksPerUser; $j++) {
                    $tasks[] = [
                        'title' => fake()->sentence(5),
                        'description' => fake()->paragraph(),
                        'assigned_to_id' => $user->id,
                        'assigned_by_id' => $allUserIds[array_rand($allUserIds)],
                        'status' => fake()->randomElement(['open', 'in_progress', 'completed']),
                        'due_date' => fake()->date(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }

                $taskChunks = array_chunk($tasks, 100);
                foreach ($taskChunks as $chunk) {
                    Task::insert($chunk);
                }
            });
        });

        $this->command->info('Seeding completed successfully!');
    }
}
