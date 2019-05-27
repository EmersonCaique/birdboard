{{ $activity->user == auth()->user() ? 'You' :auth()->user()->name  }} completed "{{ $activity->subject->body }}" task
