@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h4>Search Results for "{{ $query }}"</h4>
        @if ($tasks->isEmpty())
            <p>No tasks found matching your search criteria.</p>
        @else
            <table class="table">
                <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
