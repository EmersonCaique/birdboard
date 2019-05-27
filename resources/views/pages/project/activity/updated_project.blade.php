@if (count($activity->changes['after']) == 1)
    {{ $activity->user == auth()->user() ? 'You' :auth()->user()->name  }} updated the {{ key($activity->changes['after'])}} of the project
@else
    {{ $activity->user == auth()->user() ? 'You' :auth()->user()->name  }} update the project
@endif
