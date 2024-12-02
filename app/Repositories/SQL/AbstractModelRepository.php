<?php

namespace App\Repositories\SQL;

use App\Repositories\Contracts\IModelRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class AbstractModelRepository implements IModelRepository
{
    public function __construct(protected Model $model) {}

    // public function getAll(): Collection
    // {
    //     return $this->model->where('user_id', auth()->id())->get();
    // }

    public function getAll()
    {
        return $this->model::all(); // Ensure this returns all instances of the model
    }


    public function store(array $data): object
    {
        return $this->model->create($data);
    }

    public function find(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->find($id)->update($data);
    }

    public function search(string $query): Collection
    {
        return $this->model->where('name', 'like', "%{$query}%")->get();
    }

    public function destroy(int $id): bool
    {
        return $this->model->find($id)->delete();
    }

    public function delete($id)
    {
        $model = $this->model::findOrFail($id);
        return $model->delete();
    }

    public function withRelations(array $relations)
    {
        return  $this->model->where('assigned_to_id', auth()->id())->with($relations);
    }

    public function paginate(int $perPage = 10, string $order = 'ASC'): object
    {
        $this->model = $this->model->orderBy('created_at', $order);
        $this->model = $this->model->paginate($perPage);
        return $this;
    }
}
