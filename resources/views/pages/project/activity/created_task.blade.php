{{ $activity->user == auth()->user() ? 'You' :auth()->user()->name  }} Created a "{{ $activity->subject->body }}" task
