@extends('layouts.app')
@section('content')

<header class="flex items-end justify-between my-6">
    <h2 class="text-grey text-sm">
        My Projects
    </h2>
                <a href="/projects/create" class="button" @click.prevent="$modal.show('new-project')">New Project</a>

</header>

<div class="lg:flex lg:flex-wrap -mx-3">
    @forelse ($projects as $project)
    <div class="lg:w-1/3 px-3 pb-2">
        @include('pages.project.card')
    </div>
    @empty
    <div>
        <div>
            Nothing to show
        </div>
    </div>

    <new-project-modal></new-project-modal>

    @endforelse
</div>

@endsection
