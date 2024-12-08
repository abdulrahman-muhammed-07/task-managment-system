@extends('layouts.app')

@section('content')
    <div class="container mt-5 d-flex justify-content-center align-items-center">
        <div class="col-md-10">
            <h4>Assigned Tasks ({{ $tasks->count() }})</h4>

            <div class="mb-3">
                <form method="GET" action="{{ route('tasks.index') }}">
                    <label for="sort" class="form-label">Sort by Created Time:</label>
                    <select name="sort" id="sort" class="form-select" onchange="this.form.submit()">
                        <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Oldest First</option>
                        <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>Newest First</option>
                    </select>
                </form>
            </div>

            <table class="table">
                <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Admin Name</th>
                        <th scope="col">Assigned Name</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Status</th>
                    </tr>


                </thead>
                <tbody>
                    @forelse ($tasks as $task)
                        <tr>
                            <th scope="row">{{ $task->id }}</th>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->assignedBy?->name }}</td>
                            <td>{{ $task->assignedTo?->name }}</td>
                            <td>{{ $task->due_date }}</td>
                            <td>{{ $task->status }}</td>
                            <td>
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    @empty
                        <p>No Tasks Available</p>

                        <div class="form-group my-2">
                            <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create New Task</a>
                        </div>
                    @endforelse
                </tbody>
            </table>
            {{-- {{ $tasks->appends(['sort' => $sort])->links() }} --}}
        </div>
    @endsection
