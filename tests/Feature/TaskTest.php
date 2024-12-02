<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Jobs\UpdateStatisticsJob;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class TaskTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;


    /**
     * A basic feature test example.
     */
    public function test_logged_in_admin_can_see_tasks_list_page(): void
    {
        // Arrange
        $admin = User::factory()->create([
            'type' => User::ADMIN,
        ]);
        // Act
        $this->actingAs($admin)
            ->get('/tasks')
            // Assert
            ->assertStatus(200);
    }

    /**
     * A basic feature test example.
     */
    public function test_admin_can_add_task(): void
    {
        // Arrange
        $admin = User::factory()->create([
            'type' => User::ADMIN,
        ]);

        // Act
        $this->actingAs($admin);

        $response = $this->post('/tasks', Task::factory()->make()->toArray());

        // Assert
        $this->assertDatabaseCount('tasks', 1);

        $response->assertStatus(302);
    }

    /**
     * A basic feature test example.
     */
    public function test_tasks_list_page_show_tasks_correctly()
    {
        // Arrange
        $admin = User::factory()->create([
            'type' => User::ADMIN,
        ]);

        // Act
        $this->actingAs($admin);
        $response = $this->get('tasks');

        // Assert
        $response->assertSee('Tasks');
        $response->assertStatus(200);
    }

}
