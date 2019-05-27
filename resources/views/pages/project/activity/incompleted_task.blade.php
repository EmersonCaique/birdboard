{{ $activity->user == auth()->user() ? 'You' :auth()->user()->name  }} incompleted "{{ $activity->subject->body }}" task
