@extends('layouts.app')
@section('content')

<header class="flex items-end justify-between my-6">
    <p class="text-grey text-sm">
        <a href="{{ route('project.index') }}">My Projects</a> / {{ $project->title }}
    </p>
    <a href="{{ route('project.create')}}" class="button">New project</a>
</header>
<main>
    <div class="lg:flex -mx-3">
        <div class="lg:w-3/4 px-3 mb-6">
            <div class="mb-4">
                <h2 class="text-lg  font-normal">Tasks</h2>
                @for($project->tasks as $task)
                    <div class="card mb-3"> {{ $task->body }}</div>
                @endfor
                <div class="card">
                    <form action="{{ route('project.task.store', ['project' => $project->id ]) }}" method="post">
                        @csrf
                        <input type="text" class="w-full" placeholder="Begin adding tasks..." name="body" required>
                    </form>
                </div>
            </div>
            <div>
                <h2 class="text-lg  font-normal">General Notes</h2>
                <textarea class="card w-full"
                    style="min-height: 200px">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatem sequi laboriosam fuga consequatur aperiam veritatis debitis tempora aliquid tenetur voluptatum, expedita iste a dicta inventore quis explicabo voluptatibus eos beatae.</textarea>
            </div>
        </div>
        <div class="lg:w-1/4 px-3">
            @include('pages.project.card')
        </div>
    </div>
</main>

@endsection
