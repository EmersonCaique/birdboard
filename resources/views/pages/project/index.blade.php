@extends('layouts.app')
@section('content')

<header class="flex items-end justify-between my-6">
    <h2 class="text-grey text-sm">
        My Projects
    </h2>
    <a href="{{ route('project.create')}}" class="button">New project</a>
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

    <modal name="new-project" class="card rounded-lg" height="auto">
        <div class="p-6">
            <h1 class="text-center font-normal text-2xl mb-12 ">Lets start somenthing new</h1>

            <div class="flex ">
                <div class="mr-4 flex-1">
                    <div class="p-4">
                        <label for="title" class="mb-2 block text-normal">Title</label>
                        <input type="text" class="p-2 border border-grey rounded block w-full"
                            placeholder="Try learn piano ">
                    </div>

                    <div class="p-4">
                        <label for="description" class="mb-2 block text-normal">Description</label>
                        <textarea class="p-2 border border-grey rounded block w-full" placeholder="Try learn piano "
                            rows="7"></textarea>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <div class="p-4">
                        <label class="mb-2 block text-normal">Need some tasks?</label>
                        <input type="text" class="p-2 border border-grey rounded block w-full"
                            placeholder="Try learn piano ">
                    </div>

                    <button class="inline-flex items-center text-sm">
                        <svg class="mr-2" viewbox="0 0 18 18" height="18" width="18">
                            <g fill="#000" fill-rule="evenodd" opacity=".307">
                                <path fill="#000"
                                    d="M14.613,10c0,0.23-0.188,0.419-0.419,0.419H10.42v3.774c0,0.23-0.189,0.42-0.42,0.42s-0.419-0.189-0.419-0.42v-3.774H5.806c-0.23,0-0.419-0.189-0.419-0.419s0.189-0.419,0.419-0.419h3.775V5.806c0-0.23,0.189-0.419,0.419-0.419s0.42,0.189,0.42,0.419v3.775h3.774C14.425,9.581,14.613,9.77,14.613,10 M17.969,10c0,4.401-3.567,7.969-7.969,7.969c-4.402,0-7.969-3.567-7.969-7.969c0-4.402,3.567-7.969,7.969-7.969C14.401,2.031,17.969,5.598,17.969,10 M17.13,10c0-3.932-3.198-7.13-7.13-7.13S2.87,6.068,2.87,10c0,3.933,3.198,7.13,7.13,7.13S17.13,13.933,17.13,10">
                                </path>
                            </g>
                        </svg>
                        <span>New Task</span>
                    </button>
                </div>

            </div>


            <div class="flex justify-end my-4 mr-4">
                <button class="button is-outline">Cancel</button>
                <button class="button ml-2">Create Projcet</button>
            </div>
        </div>
    </modal>


    <a href="" @click.prevent="$modal.show('new-project')">Open</a>
    @endforelse
</div>

@endsection
