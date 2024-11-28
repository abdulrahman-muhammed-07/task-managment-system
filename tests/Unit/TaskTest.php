<?php

namespace Tests\Unit;

use App\Models\Task;
use Tests\TestCase;
use App\Repositories\SQL\TaskRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TaskTest extends TestCase
{
    use DatabaseMigrations;
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new TaskRepository(new Task());
    }

    public function test_can_get_list_of_tasks()
    {
        $tasksDataBase = Task::factory()->count(3)->create()->count();

        $tasks = $this->repository->getAll();

        $this->assertEquals($tasksDataBase, count($tasks));
    }

    public function test_can_get_task_by_id()
    {
        Task::factory()->count(3)->create([
            'title' => 'John Doe',
        ]);

        $task = $this->repository->find(1)->title;

        $this->assertEquals('John Doe', $task);
    }

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
}
