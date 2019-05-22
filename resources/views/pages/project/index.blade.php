@extends('layouts.app')
@section('content')

<header class="flex items-center justify-between my-6">
    <h2 class="text-grey text-sm">My Projects</h2>
    <a href="{{ route('project.create')}}" class="button">New project</a>
</header>

<div class="lg:flex lg:flex-wrap -mx-3">
    @forelse ($projects as $project)
        <div class="lg:w-1/3 px-3 pb-2">
            <div class="bg-white p-5 mb-4 rounded-lg shadow" style="height: 200px">
                <div class="py-2">
                    <h3 class="text-2xl mb-5 -ml-5 border-l-4 border-blue pl-4">
                        <a href="{{ route('project.show', ['project' => $project->id ]) }}">{{ $project->title }}</a>
                    </h3>
                    <div class="text-grey">{{ str_limit($project->description) }}</div>
                </div>
            </div>
        </div>
    @empty
    <div>
        <div>
            Nothing to show
        </div>
    </div>
    @endforelse
</div>

@endsection
