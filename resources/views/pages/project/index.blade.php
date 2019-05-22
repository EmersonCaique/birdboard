@extends('layouts.app')
@section('content')

<div class="flex items-center justify-between ">
    <h1>Birdboard</h1>
    <a href="{{ route('project.create')}}">Create new project</a>
</div>
<div class="flex flex-wrap justify-between">

    @forelse ($projects as $project)
    <div class="bg-white p-5 mr-1 mb-4 rounded shadow-sm w-1/3 h-1/6">
        <div>
            <h3 class="text-bold text-xl mb-5">{{ $project->title }}</h3>
            <div class="text-grey">{{ str_limit($project->description) }}</div>
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
