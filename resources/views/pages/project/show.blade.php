@extends('layouts.app')
@section('content')

<header class="flex items-end justify-between my-6">
    <p class="text-grey text-sm">
        <a href="{{ route('project.index') }}">My Projects</a> / {{ $project->title }}
    </p>
    <a href="{{ route('project.edit', ['project' => $project->id ])}}" class="button">Update project</a>
</header>
<main>
    <div class="lg:flex -mx-3">
        <div class="lg:w-3/4 px-3 mb-6">
            <div class="mb-4">
                <h2 class="text-lg  font-normal">Tasks</h2>
                @foreach($project->tasks as $task)
                    <div class="card mb-2">
                        <form method="POST"
                            action=" {{ route('project.task.update', ['project' => $project->id, 'task' => $task->id]) }} ">
                            @method('put')
                            @csrf
                            <div class="flex {{ $task->completed ? 'text-grey' : '' }}">
                                <input type="text" class="w-full" value="{{ $task->body }}" name="body" required>
                                <input type="checkbox" name="completed" onclick="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                            </div>
                        </form>
                    </div>
                @endforeach
                <div class="card">
                    <form action="{{ route('project.task.store', ['project' => $project->id ]) }}" method="post">
                        @csrf
                        <input type="text" class="w-full" placeholder="Begin adding tasks..." name="body" required>
                    </form>
                </div>
            </div>
            <div>
                <h2 class="text-lg  font-normal">General Notes</h2>
                <form action=" {{ route('project.update', ['project' => $project->id ]) }} " method="post">
                    @csrf
                    @method('put')
                    <textarea class="card w-full"style="min-height: 200px" name="notes">{{ $project->notes }}</textarea>
                    <button class="button" type="submit">Save</button>
                </form>
            </div>
        </div>
        <div class="lg:w-1/4 px-3">
            @include('pages.project.card')
        </div>
    </div>
</main>

@endsection
