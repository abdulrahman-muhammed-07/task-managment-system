<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'type' => User::ADMIN,
            'email' => 'admin@graspstudios.fho',
            'password' => bcrypt('admin')
        ]);
    }
}
