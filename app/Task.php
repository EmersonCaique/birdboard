<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['body', 'completed'];

    protected $touches = ['project'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function complete()
    {
        $this->update(['completed' => true]);

        $this->recordActivity('completed_task');
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);
        $this->recordActivity('incompleted_task');
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function recordActivity($description)
    {
        $this->activity()->create([
            'description' => $description,
            'project_id' => $this->project->id,
        ]);
    }
}
