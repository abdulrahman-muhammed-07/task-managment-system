@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h4>Search Tasks</h4>
        <form action="{{ route('tasks.search') }}" method="GET" class="mt-3">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Enter task name or description..." required>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>
@endsection
