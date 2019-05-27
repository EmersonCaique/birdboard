    <div class="card flex flex-col justify-between" style="height: 200px">
        <div class="py-2">
            <h3 class="text-2xl mb-5 -ml-5 border-l-4 border-blue pl-4">
                <a href="{{ route('project.show', ['project' => $project->id ]) }}">{{ $project->title }}</a>
            </h3>
            <div class="text-grey">{{ str_limit($project->description) }}</div>
        </div>
        <div class="text-right">
            <form action="{{ route('project.destroy', ['project' => $project->id ]) }}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="text-xs text-grey ">Delete</button>
            </form>
        </div>
    </div>
