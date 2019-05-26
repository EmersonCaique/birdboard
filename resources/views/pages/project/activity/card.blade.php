<div class='card mt-2'>
        <ul class="text-sm mb-2">
            @foreach ($project->activity as $activity)
            <li>
                @include("pages.project.activity.$activity->description")
                <span class="text-grey">
                    {{ $activity->created_at->diffForHumans(false, true) }}
                </span>
            </li>
            @endforeach
        </ul>
    </div>
