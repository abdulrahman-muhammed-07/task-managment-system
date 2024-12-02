<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Repositories\SQL\TaskRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TaskTest extends TestCase
{
    use DatabaseMigrations;
    protected $repository;


    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->count(5)->create();
        $this->repository = new TaskRepository(new Task());
    }

    public function test_can_get_list_of_tasks()
    {
        $assignedTo = User::factory()->create();
        $assignedBy = User::factory()->create();
        $tasks = Task::factory()->count(3)->create([
            'assigned_to_id' => $assignedTo->id,
            'assigned_by_id' => $assignedBy->id,
        ]);
        $retrievedTasks = $this->repository->getAll();
        $this->assertEquals($tasks->count(), $retrievedTasks->count());
    }

    public function test_can_get_task_by_id()
    {
        $task = Task::factory()->create([
            'title' => 'John Doe',
        ]);
        $foundTask = $this->repository->find($task->id);
        $this->assertEquals('John Doe', $foundTask->title);
    }

    public function test_can_update_task_by_id()
    {
        $task = Task::factory()->create([
            'title' => 'John Doe',
        ]);
        $this->repository->update($task->id, [
            'title' => 'Jane Doe',
        ]);
        $this->assertEquals('Jane Doe', $this->repository->find($task->id)->title);
    }
}
