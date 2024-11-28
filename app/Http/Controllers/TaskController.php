<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Jobs\UpdateStatisticsJob;
use App\Models\Task;
use App\Repositories\Contracts\ITaskRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\SQL\TaskRepository;
use App\Repositories\SQL\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    public function __construct(protected ITaskRepository $taskRepository, protected IUserRepository $userRepository) {}

    public function index(Request $request)
    {
        $sort = $request->get('sort', 'desc');
        $tasks = $this->taskRepository->withRelations(['assignedTo:id,name', 'assignedBy:id,name'])->orderBy('due_date', $sort)->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $users  = $this->userRepository->users(['id', 'name']);
        $admins = $this->userRepository->admins(['id', 'name']);

        return view('tasks.create', compact('users', 'admins'));
    }

    public function store(TaskRequest $request)
    {
        $this->taskRepository->store($request->validated());
        return redirect()->route('tasks.index');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $tasks = $this->taskRepository->searchTask($query);
        return view('tasks.search_results', compact('tasks', 'query'));
    }

    public function show(Task $task)
    {
        $task->load(['comments', 'assignedBy', 'assignedTo']);
        return view('tasks.show', compact('task'));
    }
}
