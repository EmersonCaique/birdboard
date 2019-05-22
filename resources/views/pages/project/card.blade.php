    <div class="card" style="height: 200px">
        <div class="py-2">
            <h3 class="text-2xl mb-5 -ml-5 border-l-4 border-blue pl-4">
                <a href="{{ route('project.show', ['project' => $project->id ]) }}">{{ $project->title }}</a>
            </h3>
            <div class="text-grey">{{ str_limit($project->description) }}</div>
        </div>
    </div>
