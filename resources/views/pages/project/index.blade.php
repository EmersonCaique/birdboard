@extends('layouts.app')
@section('content')

    <div class="flex items-center">

    </div>
    <ul>
        @forelse ($projects as $project)
            <li>
                 <a href="{{ route('project.show', ['project' => $project->id ]) }}">{{ $project->title }}</a>
            </li>
        @empty
        <li>Nothing to show</li>

        @endforelse
    </ul>

@endsection
