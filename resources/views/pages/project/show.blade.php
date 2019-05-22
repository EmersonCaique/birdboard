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
                <div class="card">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo expedita ipsum nesciunt
                    asperiores ipsam accusantium corporis laudantium nobis ipsa, aut mollitia voluptatem quas, est ea
                    sed saepe necessitatibus accusamus quaerat?</div>
            </div>
            <div>
                <h2 class="text-lg  font-normal">General Notes</h2>
                <textarea class="card w-full" style="min-height: 200px">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatem sequi laboriosam fuga consequatur aperiam veritatis debitis tempora aliquid tenetur voluptatum, expedita iste a dicta inventore quis explicabo voluptatibus eos beatae.</textarea>
            </div>
        </div>
        <div class="lg:w-1/4 px-3">
            @include('pages.project.card')
        </div>
    </div>
</main>

@endsection
