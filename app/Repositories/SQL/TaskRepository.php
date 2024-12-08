<?php

namespace App\Repositories\SQL;


use App\Models\Task;
use App\Repositories\Contracts\ITaskRepository;
use App\Repositories\SQL\AbstractModelRepository;
use Illuminate\Support\Facades\DB;

class TaskRepository extends AbstractModelRepository implements ITaskRepository
{
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }

    public function searchTask(string $searchTerm)
    {
        $userId = null;
        if (filter_var($searchTerm, FILTER_VALIDATE_EMAIL)) {
            $userId = DB::table('users')->where('email', $searchTerm)->value('id');
        }

        return $this->model
            ->when($userId, function ($query) use ($userId) {
                return $query->orWhere('description', $userId); // Assuming 'user_id' is the column for task assignments
            })
            ->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('status', 'LIKE', "%{$searchTerm}%");
            })
            ->get();
    }

}
